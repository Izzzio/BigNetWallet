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

use Cake\Cache\Cache;
use Cake\Log\Log;
use Cake\Network\Request;


class Test extends Payment
{


    const CACHE_CONFIG = 'payment';


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
        ];
        $transactions += $additions;
        $result = ['result' => 'ok'];

        $transactions['result'] = $result;

        Cache::write($invoice, $transactions, self::CACHE_CONFIG);

        return $transactions;
    }


    public static function createDeposit($amount, $currency, $invoice, $additions = [])
    {
        return self::createTransaction($amount, $currency, $invoice, $additions);
    }

    /**
     * Process payment
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public static function processPayment($request, $invoice)
    {

        $invoice = $_GET['invoice'];

        $transactionData = Cache::read($invoice, self::CACHE_CONFIG);
        debug($transactionData);

        if (empty($transactionData)) {
            throw new \Exception('No transaction data loaded');
        }

        $amount1 = floatval($_GET['amount1']);
        $currency1 = $_GET['currency1'];


        return ['amount' => '1', 'currency' => 'ETH', 'txData' => $transactionData+['userId'=>1,'deposit'=>true]];
    }
}