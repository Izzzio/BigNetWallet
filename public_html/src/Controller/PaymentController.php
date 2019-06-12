<?php

namespace App\Controller;


use App\Lib\Calculator;
use App\Lib\CPA;
use App\Lib\CoinMarketCap;
use App\Lib\GoogleAnalitycs;
use App\Lib\KeyValue;
use App\Lib\Payments\CoinPayments;
use App\Lib\Referal;
use App\Model\Entity\User;
use App\Model\Table\TransactionsTable;
use App\Model\Table\UsersTable;

use Cake\Cache\Cache;
use Cake\Event\Event;

use App\Lib\Email;
use Cake\I18n\Time;


/**
 * Payment processor
 * @package App\Controller
 */
class PaymentController extends AppController
{


    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->IndianAuth->allow(['process'], 'all');

        $this->set('user', false);
    }

    /**
     * Process payment by gate
     * @param string $gate Payment gate class name
     * @param string $invoice
     * @throws \Exception
     */
    public function process($gate, $invoice = null)
    {
        /**
         * @var CoinPayments $classString
         */
        $classString = 'App\\Lib\\Payments\\' . $gate;


        $paymentResult = $classString::processPayment($this->request, $invoice);
        $userId = $paymentResult['txData']['userId'];
        $clickId = isset($paymentResult['txData']['clickId']) ? $paymentResult['txData']['clickId'] : 0;
        if (empty($userId)) {
            throw new \Exception('User for transaction not found ' . print_r($paymentResult, true));
        }

        if (!isset($paymentResult['txData']['deposit'])) {
            throw new \Exception('No deposit flag for transaction ' . print_r($paymentResult, true));
        }

        $deposit = $paymentResult['txData']['deposit'];

        $amount = $paymentResult['amount'];
        $currency = $paymentResult['currency'];

        $usd = CoinMarketCap::token2usd($amount, $currency);

        $money['BTC'] = CoinMarketCap::usd2token($usd, 'BTC', 10);
        $money['ETH'] = CoinMarketCap::usd2token($usd, 'ETH', 10);


        $transaction = TransactionsTable::instance()->newEntity([
            'amount'         => $amount,
            'currency'       => $currency,
            'user_id'        => $userId,
            'usd'            => $usd,
            'rawdata'        => json_encode($paymentResult),
            'currencys_rate' => @json_encode($money),
            'type'           => 'INCOME',
        ]);

        if (!TransactionsTable::instance()->save($transaction)) {
            throw  new \Exception('Transaction saving error ' . print_r($transaction, true));
        }

        $user = UsersTable::instance()->get($userId);

        //Положить деньги на депозит
        if ($deposit) {

            if (!UsersTable::instance()->updateAll(['balance = balance+' => floatval($usd)], ['id' => $user->id])) {
                throw new \Exception('Cant change balance for user ' . $userId . ' on ' . $usd . ' USD');
            }

            KeyValue::write('new_transaction_' . $user->id, json_encode([
                'amount'   => $amount,
                'currency' => $currency,
            ]));
        } else {
            $tokens = Calculator::usdToTokenSale($usd, null, $user->id);

            Referal::referalBuy($user, Calculator::usdToToken($usd));

            $bonus = Calculator::getTokenBonus($tokens, null, $user->id);
            $bonusReferral = Referal::getAllReferalBonus($user)['total'];
            //$bonus += $bonusReferral;

            $tokensBonus = Calculator::usdToToken($usd) * ($bonus / 100);


            $money['BTC'] = CoinMarketCap::usd2token($usd, 'BTC');
            $money['ETH'] = CoinMarketCap::usd2token($usd, 'ETH');

            //Создаем транзакцию-трату
            $transaction = TransactionsTable::instance()->newEntity([
                'amount'         => -$tokens,
                'currency'       => 'token',
                'user_id'        => $userId,
                'usd'            => -$usd,
                'rawdata'        => 'Buying from payment processing with bonus ' . $bonus . '% calculated as ' . $tokensBonus . ' of ' . $tokens . ' tokens',
                'currencys_rate' => @json_encode($money, JSON_UNESCAPED_UNICODE),
                'type'           => 'TOKEN_BUY',
            ]);

            if (!TransactionsTable::instance()->save($transaction)) {
                throw  new \Exception('Transaction saving error ' . print_r($transaction, true));
            }

            if (!UsersTable::instance()->updateAll([
                'tokens = tokens+'             => $tokens,
                'tokens_bonus = tokens_bonus+' => $tokensBonus,
            ], ['id' => $user->id])) {
                throw new \Exception('Cant change tokens for user ' . $userId . ' on ' . $usd . ' USD');
            }

            /*CPA::request($clickId, 'paid', [
                'sum'       => $usd,
                'currency'  => 'USD',
                'action_id' => $transaction->id,
                'revenue'   => $usd * 0.15,
            ]);*/

            CPA::pay($clickId, $userId, $amount, $currency, $transaction->id, $tokens);
        }

        GoogleAnalitycs::request([
            'uid' => $userId,
            'cid' => $userId,
            'ec'  => 'account',
            'ea'  => 'payment',
            'el'  => 'success',
        ]);

        die('IPN OK');
    }
}

