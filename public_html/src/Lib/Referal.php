<?php

namespace App\Lib;

use App\Controller\Component\IndianAuthComponent;
use App\Model\Entity\User;
use App\Model\Table\TransactionsTable;
use App\Model\Table\UsersTable;
use Cake\Core\Configure;
use Cake\Utility\Security;


/**
 * Referal logic
 * @package App\Lib
 */
class Referal
{

    const REFERAL_BONUS = 5; //5%


    /**
     * @return % of referral bonus
     */
    public static function getReferalBonus()
    {
        $bonus = Configure::read('App.referalBonus');
        if (!empty($bonus)) {
            return $bonus;
        }

        return self::REFERAL_BONUS;
    }

    /**
     * @param User $user
     * @param float $amount
     * @throws \Exception
     */
    public static function referalBuy($user, $amount)
    {
        if (empty($user->ref_user)) {
            return;
        }

        /**
         * @var User $reciver
         */
        $reciver = UsersTable::f()->where(['id' => $user->ref_user])->first();

        if (empty($reciver)) {
            return;
        }


        /*
        $additionalBonus = 0;

        if (!empty($reciver->personal_referal_bonus)) {
            $additionalBonus = $reciver->personal_referal_bonus;
        }

        $bonusSumm = self::getReferalBonus() + $additionalBonus;
        */
        $bonusSumm = self::getAllReferalBonus($reciver)['total'];


        $bonus = $amount * (($bonusSumm) / 100);

        $reciver->tokens += $bonus;

        if (!UsersTable::instance()->save($reciver)) {
            throw  new \Exception('Transaction saving error ' . print_r($reciver, true));
        }

        $amountInUSD = Calculator::token2Usd($amount);
        $money['BTC'] = CoinMarketCap::usd2token($amountInUSD, 'BTC', 10);
        $money['ETH'] = CoinMarketCap::usd2token($amountInUSD, 'ETH', 10);

        $transaction = TransactionsTable::instance()->newEntity([
            'amount'    => -$bonus,
            'currency'  => 'token',
            'user_id'   => $reciver->id,
            'usd'       => 0,
            'rawdata'   => 'Referral with bonus ' . $bonusSumm . '% from ' . $user->id,
            'currencys_rate'    => @json_encode($money, JSON_UNESCAPED_UNICODE),
            'type'      => 'REFERRAL_INCOME',
            'entity_id' => $user->id,
        ]);

        if (!TransactionsTable::instance()->save($transaction)) {
            throw  new \Exception('Transaction saving error ' . print_r($transaction, true));
        }

    }

    /**
     * Gets user referal bonuses
     * @param object $reciver
     * @return array persents(%) for each type bonus
     */
    public static function getAllReferalBonus($reciver = null)
    {
        $bonus = [
            'referral' => 0,
            'personal' => 0,
            'total' => 0
        ];
        $bonus['referral'] = self::getReferalBonus();

        if ($reciver->personal_referal_bonus && !empty($reciver->personal_referal_bonus)) {
            $bonus['personal'] = $reciver->personal_referal_bonus;
        }

        $bonus['total'] = $bonus['referral'] + $bonus['personal'];
        return $bonus;
    }

    /**
     * Gets user referals
     * @param int $userId
     * @return array
     */
    public static function getUserReferals($userId)
    {
        $refs = UsersTable::f()->where(['ref_user' => $userId])->order(['created' => 'DESC']);
        //массив из идентификаторов пользователей, которые купили по токену текущего пользователя
        $refUsers = array_column($refs->toArray(), 'id');
        if (empty($refUsers)) {
            return [];
        }

        $refsMoney = TransactionsTable::f('list', [
            'keyField'   => 'entity_id',
            'valueField' => 'summ',
            //'groupField' => 'entity_id',
        ])
            ->select([
                'entity_id',
                'summ' => 'SUM(amount)',
            ])
            ->where([
                'user_id'      => $userId,
                'type'         => 'REFERRAL_INCOME',
                'entity_id IN' => $refUsers,
                'amount <'     => 0,
            ])
            ->group([
                'entity_id',
            ])
            ->toArray();

        $referals = [];
        foreach ($refs as $ref) {
            $referralAmount = 0;
            if (isset($refsMoney[$ref->id])) {
                $referralAmount = $refsMoney[$ref->id];
                $referals[] = [
                    'id'      => $ref->id,
                    'name'    => $ref->email,
                    'created' => $ref->created,
                    'amount'  => abs($referralAmount),
                ];
            } else {
                //возможно есть начисления по старому правилу: процент от баланса токенов реферала
                $refsMoneyOld = TransactionsTable::f()
                    ->select([
                        'summ' => 'SUM(amount)',
                    ])
                    ->where([
                        'user_id'    => $ref->id,
                        'created <=' => '2018-03-07 23:59:59',
                        'type !='    => 'REFERRAL_INCOME',
                        'AND'        => [
                            ['rawdata not LIKE' => '%referral%'],
                            ['rawdata not LIKE' => '%Referal%'],
                        ],
                        'currency'   => 'token',
                        'amount <'   => 0,
                    ])
                    ->group([
                        'user_id',
                    ])
                    ->first();

                if (isset($refsMoneyOld)) {
                    $referralAmount = $refsMoneyOld->summ;
                    $referals[] = [
                        'id'      => $ref->id,
                        'name'    => $ref->email,
                        'created' => $ref->created,
                        'amount'  => abs($referralAmount) * (\App\Lib\Referal::getReferalBonus() / 100),
                    ];
                }


            }


        }

        return $referals;
    }
    /*
        public static function getRefsMoneyByOldRules($refUsers)
        {
            $refsMoney = TransactionsTable::f('list', [
                'keyField'   => 'user_id',
                'valueField' => 'summ',
            ])
                ->select([
                    'summ' => TransactionsTable::f()->func()->sum('amount'),
                    'user_id',
                ])
                ->where([
                    'user_id IN' => $refUsers,
                    'amount < 0',  //пользователь тратил свои токены
                    'created' < '03-07-2018 00:00:00',
                    'type !='    => 'REFERRAL_INCOME',
                ])
                ->toArray();

            return is_array($refsMoney) ? $refsMoney : [];
        }

        public static function getRefsMoneyByNewRules($refUsers)
        {
            $refsMoney = TransactionsTable::f('list', [
                'keyField'   => 'user_id',
                'valueField' => 'summ',
            ])
                ->select([
                    'summ' => TransactionsTable::f()->func()->sum('amount'),
                    'user_id',
                ])
                ->where([
                    'user_id IN' => $refUsers,
                    'amount < 0',  //пользователь тратил свои токены
                    'created' >= '03-07-2018 00:00:00',
                    'type'       => 'REFERRAL_INCOME',
                ])
                ->toArray();

            return is_array($refsMoney) ? $refsMoney : [];
        }*/
}