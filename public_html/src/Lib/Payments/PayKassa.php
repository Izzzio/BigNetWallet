<?php
/*
 * iZ³ Crowdsale platform
 * Copyright (c) iZ³ | Izzz.io platform (izzz.io)
 * You can contact the copyright holder by e-mail info@izzz.io
 *
 * @copyright iZ³ | Izzz.io platform (izzz.io)
 * @link https://izzz.io
 * @author Dmitriy Elsukov (demndik@yandex.ru)
 *
 */

namespace App\Lib\Payments;

use App\Lib\CoinMarketCap;
use App\Model\Table\LogTable;
use Cake\Cache\Cache;
use Cake\Core\Configure;
//use Cake\Log\Log;
use Cake\Network\Request;

require_once('classes/paykassa_sci.class.php');
require_once('classes/paykassa_api.class.php');

class PayKassa extends Payment
{

    /**
     * Always named as current class
     */
    const NAME = 'PayKassa';
    const DISABLED = false;

    const CACHE_CONFIG = 'payment';
    const DEPOSIT_CACHE_CONFIG = 'deposit';

    private static $_instanceSCI = null;
    private static $_instanceAPI = null;

    private static $_systemId = [
        "bitcoin"          => 11, // поддерживаемая валюта BTC
        "ethereum"         => 12, // поддерживаемая валюта ETH
        "litecoin"         => 14, // поддерживаемая валюта LTC
        "dogecoin"         => 15, // поддерживаемая валюта DOGE
        "dash"             => 16, // поддерживаемая валюта DASH
        "bitcoin-cash"     => 18, // поддерживаемая валюта BCH
        "zcash"            => 19, // поддерживаемая валюта ZEC
        "monero"           => 20, // поддерживаемая валюта XMR
        "ethereum-classic" => 21, // поддерживаемая валюта ETC
        "ripple"           => 22, // поддерживаемая валюта XRP
    ];

    private static $_systemFiatId = [
        "payeer"       => 1,  // поддерживаемая валюта RUB USD
        "perfectmoney" => 2,  // поддерживаемая валюта USD
        "advcash"      => 4,  // поддерживаемая валюта RUB USD
    ];

    /**
     * Returns instance
     * @return \PayKassaAPI|null
     */
    public static function instanceAPI()
    {
        if (empty(static::$_instanceAPI)) {
            self::$_instanceAPI = new \PayKassaAPI(
                Configure::read('App.payKassa.api_id'),
                Configure::read('App.payKassa.api_password')
            );
        }

        return static::$_instanceAPI;
    }

    /**
     * Returns instance
     * @return \PayKassaSCI|null
     */
    public static function instanceSCI()
    {
        if (empty(static::$_instanceSCI)) {
            self::$_instanceSCI = new \PayKassaSCI(
                Configure::read('App.payKassa.merchant_id'),
                Configure::read('App.payKassa.merchant_password')
            );
        }

        return static::$_instanceSCI;
    }

    /**
     * Creates new transaction
     * @param float $amount
     * @param string $currency
     * @param string $orderNum
     * @param array $additions
     * @return array
     * @throws \Exception
     */
    public static function createDeposit($amount, $currency, $orderNum, $additions = [])
    {
        $currencySystem = CoinMarketCap::SHORT_LONG[$currency];
        if (!$currencySystem) {
            throw new \Exception(__('Not found currency full name'));
        }

        $transaction = [
            // обязательный параметр, сумма платежа, пример: 1.0433
            'amount'    => floatval($amount),
            // обязательный параметр, валюта, пример: BTC
            'currency'  => $currency,
            // обязательный параметр, уникальный числовой идентификатор платежа в вашем системе, пример: 150800
            'order_num' => $orderNum,
            // обязательный параметр, текстовый комментарй платежа, пример: Заказ услуги #150800
            'comment'   => __('Order of service ') . $orderNum,
            // обязательный параметр, указав его, Вас, минуя мерчант, переадресует на платежную систему, пример: 12 - Ethereum
            'system_id' => self::$_systemId[$currencySystem],
        ];
        $transaction += $additions;
        $result = self::instanceSCI()->sci_create_order_get_data(
            $transaction['amount'],
            $transaction['currency'],
            $transaction['order_num'],
            $transaction['comment'],
            $transaction['system_id']
        );

        if ($result['error']) {
            throw new \Exception($result['message']);
        }

        /*
        $invoice = $result['data']['invoice'];     // Нормер операции в системе Paykassa.pro
        $order_id = $result['data']['order_id'];   // Ордер в магазине
        $wallet = $result['data']['wallet'];       // Адрес для оплаты
        $amount = $result['data']['amount'];       // Сумма к оплате, может измениться, если комиссия переведена на клинета
        $system = $result['data']['system'];       // Система, в которой выставлен счет
        $url = $result['data']['url'];             // Ссылка для перехода на оплату
        $tag = $result['data']['tag'];             // Тег, указать при переводе для ripple
        */

        $transaction['result'] = $result;

        Cache::write($orderNum, $transaction, self::DEPOSIT_CACHE_CONFIG);

        LogTable::write('PK_CreateDeposit', $transaction, empty($additions['userId']) ? null : $additions['userId']);

        return self::unifyTransaction($result['data']);
    }

    /**
     * Unify data in transaction
     * @param array $transaction
     * @return array
     */
    private static function unifyTransaction($transaction = [])
    {
        foreach ($transaction as $key => $value) {
            switch ($key) {
                case 'order_id':
                    $keyNew = 'invoice';
                    break;
                case 'wallet':
                    $keyNew = 'address';
                    break;
                case 'url':
                    $keyNew = 'link_for_pay';
                    break;
                case 'tag':
                    $keyNew = 'dest_tag';
                    break;
                default:
                    $keyNew = false;
            }
            if ($keyNew) {
                $transaction[$keyNew] = $value;
                unset($transaction[$key]);
            }
        }

        return $transaction;
    }

    /**
     * Process payment
     * @param Request $request
     * @param string $invoice
     * @return array
     * @throws \Exception
     */
    public static function processPayment($request, $invoice)
    {
        $res = self::instanceSCI()->sci_confirm_order();
        if ($res['error']) {        // $res['error'] - true если ошибка
            throw new \Exception($res['message']); // $res['message'] - текст сообщения об ошибке
        }

        $invoice = $res["data"]["order_id"];        // уникальный числовой идентификатор платежа в вашем системе, пример: 150800
        $transaction = $res["data"]["transaction"]; // номер транзакции в системе paykassa: 96401
        $hash = $res["data"]["hash"];               // hash, пример: bde834a2f48143f733fcc9684e4ae0212b370d015cf6d3f769c9bc695ab078d1
        $currency = $res["data"]["currency"];       // валюта платежа, пример: DASH
        $system = $res["data"]["system"];           // система, пример: Dash
        $address = $res["data"]["address"];         // адрес криптовалютного кошелька, пример: Xybb9RNvdMx8vq7z24srfr1FQCAFbFGWLg

        $partial = $res["data"]["partial"];         // настройка приема недоплаты или переплаты, 'yes' - принимать, 'no' - не принимать
        $amount = (float)$res["data"]["amount"];    // сумма счета, пример: 1.0000000

        if ($partial === 'yes') {
            // сумма заявки может не совпадать с полученной суммой, если включен режим частичной оплаты
            // актально только для криптовалют, поумолчанию 'no'
        }

        if (!$invoice || empty($invoice)) {
            throw new \Exception('No transaction invoice data proceed' . print_r($_POST, true));
        }

        $transactionData = Cache::read($invoice, self::DEPOSIT_CACHE_CONFIG);

        if (empty($transactionData)) {
            throw new \Exception('No transaction data loaded ' . $invoice . ' ' . print_r($_REQUEST, true));
        }
        if ($currency != $transactionData['currency']) {
            throw new \Exception('Original currency mismatch!');
        }

        echo $invoice . '|success'; // обязательно, для подтверждения зачисления платежа

        return [
            'amount'   => $amount,
            'currency' => $currency,
            'txData'   => $transactionData + ['deposit' => print_r($_POST, true)],
        ];
    }

    /**
     * Tile in admin interface
     */

    public static function drawAdminTile()
    {
        ?>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">PayKassa</h3>
                </div>
                <div class="box-body" style="overflow-x: scroll">
                        <b>API ID: </b><span
                                style="font-size: 10pt"><?= Configure::read('App.payKassa.api_id') ?></span><br>
                        <b>Merchant ID: </b><span
                                style="font-size: 10pt"><?= Configure::read('App.payKassa.merchant_id') ?></span><br>
                        <b>IPN Url: </b><span
                                style="font-size: 10pt"><?= self::getIPNUrl() ?></span><br>
                </div>
            </div>
        </div>
        <?php
    }

}