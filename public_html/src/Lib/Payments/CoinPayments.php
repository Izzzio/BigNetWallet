<?php
/*
 * iZ³ Crowdsale platform
 * Copyright (c) iZ³ | Izzz.io platform (izzz.io)
 * You can contact the copyright holder by e-mail info@izzz.io
 *
 * @copyright iZ³ | Izzz.io platform (izzz.io)
 * @link https://izzz.io
 * @author Andrey Nedobylsky (andrey@izzz.io)
 *
 */

namespace App\Lib\Payments;

use App\Model\Table\LogTable;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Network\Request;

require('classes/coinpayments.inc.php');

class CoinPayments extends Payment
{

    /**
     * Always named as current class
     */
    const NAME = 'CoinPayments';
    const DISABLED = false;

    const CACHE_CONFIG = 'payment';
    const DEPOSIT_CACHE_CONFIG = 'deposit';


    private static $_cps = null;

    /**
     * Returns instance
     * @return \CoinPaymentsAPI|null
     */
    public static function instance()
    {
        if (empty(static::$_cps)) {
            self::$_cps = new \CoinPaymentsAPI();
            self::$_cps->Setup(Configure::read('App.coinPayments.PRIVATE_KEY'), Configure::read('App.coinPayments.PUBLIC_KEY'));

        }

        return static::$_cps;
    }


    /**
     * Creates new transaction
     * @param float $amount
     * @param string $currency
     * @param string $invoice
     * @param array $additions
     * @return array
     * @throws \Exception
     */
    public static function createTransaction($amount, $currency, $invoice, $additions = [])
    {
        $transactions = [
            'amount'    => floatval($amount),
            'currency1' => $currency,
            'currency2' => $currency,
            'invoice'   => $invoice,
            'ipn_url'   => self::getIPNUrl(),

        ];
        $transactions += $additions;
        $result = self::instance()->CreateTransaction($transactions);
        if ($result['error'] != 'ok') {
            throw new \Exception($result['error']);
        }

        $transactions['result'] = $result;

        Cache::write($invoice, $transactions, self::CACHE_CONFIG);

        return $result['result'];
    }

    /**
     * Creates new transaction
     * @param float $amount
     * @param string $currency
     * @param string $invoice
     * @param array $additions
     * @return array
     * @throws \Exception
     */
    public static function createDeposit($amount, $currency, $invoice, $additions = [])
    {
        $transactions = [
            'amount'    => floatval($amount),
            'currency1' => $currency,
            'currency2' => $currency,
            'invoice'   => $invoice,
            'ipn_url'   => self::getIPNUrl() . '/' . $invoice,

        ];
        $transactions += $additions;
        $result = self::instance()->GetCallbackAddress($currency, self::getIPNUrl() . '/' . $invoice);
        if ($result['error'] != 'ok') {
            throw new \Exception($result['error']);
        }

        $transactions['result'] = $result;

        Cache::write($invoice, $transactions, self::DEPOSIT_CACHE_CONFIG);

        LogTable::write('CP_CreateDeposit', $transactions, empty($additions['userId']) ? null : $additions['userId']);

        return self::unifyTransaction($result['result'] + ['invoice' => $invoice]);
    }

    /**
     * Gets exchange rates
     * @param bool $short
     * @return array
     */
    public static function getExchangeRates($short = false)
    {
        return self::instance()->GetRates($short);
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

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            throw new \Exception('IPN Mode is not HMAC' . print_r($_POST, true));
        }

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            throw new \Exception("No HMAC signature sent");
        }

        $merchant = isset($_POST['merchant']) ? $_POST['merchant'] : '';
        if (empty($merchant)) {
            throw new \Exception("No Merchant ID passed");
        }

        if ($merchant != Configure::read('App.coinPayments.MERCHANT_ID')) {
            throw new \Exception("Invalid Merchant ID");
        }

        $rawRequest = file_get_contents('php://input');
        if ($rawRequest === false || empty($rawRequest)) {
            throw new \Exception("Error reading POST data");
        }

        $hmac = hash_hmac("sha512", $rawRequest, Configure::read('App.coinPayments.IPN_SECRET'));
        if ($hmac != $_SERVER['HTTP_HMAC']) {
            throw new \Exception("HMAC signature does not match");
        }

        if (empty($invoice)) {
            $invoice = $_POST['invoice'];
            if (empty($_POST['invoice'])) {
                throw new \Exception('No transaction invoice data proceed' . print_r($_POST, true));
            }
        } else {
            // Log::error('AAAA' . print_r($_POST, true));
        }


        if ($_POST['ipn_type'] !== 'deposit') {
            $transactionData = Cache::read($invoice, self::CACHE_CONFIG);

            if (empty($transactionData)) {
                throw new \Exception('No transaction data loaded ' . $invoice . ' ' . print_r($_REQUEST, true));
            }

            $txn_id = $_POST['txn_id'];
            $amount1 = floatval($_POST['amount1']);
            $amount2 = floatval($_POST['amount2']);
            $currency1 = $_POST['currency1'];
            $currency2 = $_POST['currency2'];
            $status = intval($_POST['status']);
            $statusText = $_POST['status_text'];

            if ($currency1 != $transactionData['currency1']) {
                throw new \Exception('Original currency mismatch!');
            }

            /*if ($amount1 < $transactionData['amount']) {
                throw new \Exception('Amount is less than order total!');
            }*/

            /**
             * Payment status check
             */
            if ($status == 1) {
                Cache::write($invoice, false, self::CACHE_CONFIG); //clear cache
            } else {
                if ($status >= 100 || $status == 2) {
                    throw new \Exception($statusText);
                } else {
                    if ($status < 0) {
                        throw new \Exception($statusText . $txn_id . ' ' . $invoice);
                    } else {
                        throw new \Exception($statusText);
                    }
                }
            }

            return [
                'amount'   => $amount1,
                'currency' => $currency1,
                'txData'   => $transactionData + ['invoice' => print_r($_POST, true)],
            ];
        } else {
            $transactionData = Cache::read($invoice, self::DEPOSIT_CACHE_CONFIG);

            if (empty($transactionData)) {
                throw new \Exception('No transaction data loaded ' . $invoice . ' ' . print_r($_REQUEST, true));
            }


            $txn_id = $_POST['txn_id'];
            $amount1 = floatval($_POST['amount']);
            $currency1 = $_POST['currency'];
            $status = intval($_POST['status']);
            $statusText = $_POST['status_text'];

            if ($status < 100 && $status != 1) {
                throw new \Exception($statusText . $txn_id . ' ' . $invoice);
            }

            //  Cache::write($invoice, false, self::CACHE_CONFIG); //clear cache

            return [
                'amount'   => $amount1,
                'currency' => $currency1,
                'txData'   => $transactionData + ['deposit' => print_r($_POST, true)],
            ];
        }
    }

    private static function unifyTransaction($transaction = []){

        return $transaction;
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
                    <h3 class="box-title">Coin Payments</h3>
                </div>
                <div class="box-body" style="overflow-x: scroll">
                    <b>Public key: </b><span
                            style="font-size: 10pt"><?= h(Configure::read('App.coinPayments.PUBLIC_KEY')) ?></span><br>
                    <b>Merchant ID: </b><span
                            style="font-size: 10pt"><?= h(Configure::read('App.coinPayments.MERCHANT_ID')) ?></span><br>
                    <b>IPN Url: </b><span
                            style="font-size: 10pt"><?= h(self::getIPNUrl()) ?></span><br>
                </div>
            </div>
        </div>
        <?php
    }
}
