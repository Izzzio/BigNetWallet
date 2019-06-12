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

use App\Model\Table\LogTable;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Network\Request;

require('classes/BitcoinValve.php');

class BitcoinValve extends Payment
{

    /**
     * Always named as current class
     */
    const NAME = 'BitcoinValve';
    const DISABLED = false;

    const CACHE_CONFIG = 'payment';
    const DEPOSIT_CACHE_CONFIG = 'deposit';


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
        return ['error' => 'BitcoinValve can\'t receive fixed transactions'];
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

        $result = \BitcoinValve::createDeposit(self::getIPNUrl() . '/' . $invoice);

        $transactions['result'] = $result;

        Cache::write($invoice, $transactions, self::DEPOSIT_CACHE_CONFIG);

        LogTable::write('BV_CreateDeposit', $transactions, empty($additions['userId']) ? null : $additions['userId']);

        return $result + ['invoice' => $invoice];
    }

    /**
     * Get BTCValve address
     * @return string
     */
    public static function getAddress()
    {
        return Configure::read('App.btcvalve.address');
    }

    /**
     * Process payment
     * @param Request $request
     * @param string $invoice
     * @return array
     * @throws \Exception
     */
    public static function processPayment($request, $invoice = '')
    {
        if (!$request->is('post')) {
            throw new \Exception('Wrong request type.');
        }

        if (empty($invoice)) {
            $invoice = $request->data['invoice'];
            if (empty($invoice)) {
                throw new \Exception('No transaction invoice data proceed' . print_r($request->data, true));
            }
        }

        $transactionData = Cache::read($invoice, self::DEPOSIT_CACHE_CONFIG);

        if (empty($transactionData)) {
            throw new \Exception('No transaction data loaded ' . $invoice . ' ' . print_r($_REQUEST, true));
        }

        $amount = floatval($request->data['btc']);
        $currency = 'BTC';

        if (empty($amount)) {
            throw new \Exception('Empty amount ' . $invoice . ' ' . print_r($request->data, true));
        }

        return [
            'amount'   => $amount,
            'currency' => $currency,
            'txData'   => $transactionData + ['depositInfo' => print_r($request->data, true)],
            'info'     => print_r($request->data, true),
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
                <h3 class="box-title">BTCValve - iZ³ Bitcoin gate</h3>
            </div>
            <div class="box-body" style="overflow-x: scroll">
                <div style="overflow-x: scroll">
                    <b>Base address: </b><span
                            style="font-size: 10pt"><?= empty(self::getAddress()) ?
                            '<span style="color: red">Not specifed</span>' : self::getAddress() ?></span><br>
                    <b>BTCValve gate: </b><span
                            style="font-size: 10pt"><?= \BitcoinValve::BITCOINVALVE_URL ?></span><br>
                    <b>IPN Url: </b><span
                            style="font-size: 10pt"><?= self::getIPNUrl() ?></span><br>
                    <b>BTCValve ping: </b><span
                            style="font-size: 10pt"><?= file_get_contents(\BitcoinValve::BITCOINVALVE_URL) ?></span><br>
                </div>
            </div>
        </div>
        </div>
        <?php
    }

}