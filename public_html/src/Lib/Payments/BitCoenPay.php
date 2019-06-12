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


class BitCoenPay extends Payment
{

    /**
     * Always named as current class
     */
    const NAME = 'BitCoenPay';
    const DISABLED = false;

    const CACHE_CONFIG = 'payment';
    const DEPOSIT_CACHE_CONFIG = 'deposit';

    const GATE_URL = 'https://pay.bitcoen.io/';


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
        return ['error' => 'BitCoen can\'t receive fixed transactions'];
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

        if (empty(self::getAddress())) {
            throw new \Exception('BitCoen Pay no address specified');
        }

        $transactions = [
            'amount'    => floatval($amount),
            'currency1' => $currency,
            'currency2' => $currency,
            'invoice'   => $invoice,
            'ipn_url'   => self::getIPNUrl() . '/' . $invoice,

        ];
        $transactions += $additions;

        $ipnUrl = self::getIPNUrl() . '/' . $invoice;

        $data = file_get_contents(self::GATE_URL . 'createDeposit/?callback=' . urlencode($ipnUrl) . '&receiverAddress=' . urlencode(self::getAddress()));
        $result = json_decode($data, true);

        if (!$result) {
            throw new \Exception('BitCoen Pay request error. Try again later');
        }

        $result['address'] = $result['data']['wallet']['id'];

        $transactions['result'] = $result;

        Cache::write($invoice, $transactions, self::DEPOSIT_CACHE_CONFIG);

        LogTable::write('BC_CreateDeposit', $transactions, empty($additions['userId']) ? null : $additions['userId']);

        return $result + ['invoice' => $invoice];
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

        if (empty($invoice)) {
            $invoice = $_POST['invoice'];
            if (empty($_POST['invoice'])) {
                throw new \Exception('No transaction invoice data proceed' . print_r($_POST, true));
            }
        } else {
            // Log::error('AAAA' . print_r($_POST, true));
        }


        $transactionData = Cache::read($invoice, self::DEPOSIT_CACHE_CONFIG);

        if (empty($transactionData)) {
            throw new \Exception('No transaction data loaded ' . $invoice . ' ' . print_r($_REQUEST, true));
        }


        $amount1 = floatval($_POST['amount']);
        $currency1 = 'BEN';

        if (empty($amount1)) {
            throw new \Exception('Empty amount ' . $invoice . ' ' . print_r($_POST, true));
        }

        return [
            'amount'   => $amount1,
            'currency' => $currency1,
            'txData'   => $transactionData + ['depositInfo' => print_r($_POST, true)],
            'info'     => print_r($_POST, true),
        ];

    }


    public static function getAddress()
    {
        return Configure::read('App.bitcoenpay.address');
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
                    <h3 class="box-title">BitCoen Pay</h3>
                </div>
                <div class="box-body" style="overflow-x: scroll">
                    <b>Base address: </b><span
                            style="font-size: 10pt"><?= empty(self::getAddress()) ?
                            '<span style="color: red">Not specifed</span>' : h(self::getAddress()) ?></span><br>
                    <b>Gate URL: </b><span
                            style="font-size: 10pt"><?= h(self::GATE_URL) ?></span><br>
                    <b>IPN Url: </b><span
                            style="font-size: 10pt"><?= h(self::getIPNUrl()) ?></span><br>
                    <b>Service ping: </b><span
                            style="font-size: 10pt"><?= h(file_get_contents(self::GATE_URL . 'ping.php')) ?></span><br>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * BitCoen Pay ticker
     * @return array
     */
    public static function getUsdPriceArray()
    {
        return ['bitcoen' => ['price_usd' => (file_get_contents(self::GATE_URL . 'ticker.php?currency=usd'))]];
    }

}
