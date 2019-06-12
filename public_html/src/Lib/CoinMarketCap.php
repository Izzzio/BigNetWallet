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

namespace App\Lib;

use App\Lib\Payments\Payment;
use Cake\Cache\Cache;

/**
 * Coin market cap API provider
 * @package App\Lib
 */
class CoinMarketCap
{

    const API_URL = 'https://api.coinmarketcap.com/v1/ticker/';

    //currencies
    const CURRENCIES = [
        'bitcoin',
        'ethereum',
        'litecoin',
        'ethereum-classic',
        'ripple',
        'waves',
        'dash',
        'ripple',
        'bitcoin-cash',
        'tether',
        'iota',
        'eos',
        'cardano',
        'stellar',
        'monero',
        'neo',
    ];

    const SHORT_LONG = [
        'BTC'  => 'bitcoin',
        'ETH'  => 'ethereum',
        'ETC'  => 'ethereum-classic',
        'LTC'  => 'litecoin',
        'WAVE' => 'waves',
        'DASH' => 'dash',
        'XRP'  => 'ripple',
        'BCH'  => 'bitcoin-cash',
        'USDT' => 'tether',
        'IOTA' => 'iota',
        'EOS'  => 'eos',
        'ADA'  => 'cardano',
        'XLM'  => 'stellar',
        'XMR'  => 'monero',
        'NEO'  => 'neo',
        'BEN'  => 'bitcoen',
        'DOGE' => 'dogecoin',
        'ZEC'  => 'zcash',
    ];

    /**
     * Retrive all currency capitalization
     * @param bool $ignoreCache
     * @return array
     */
    static public function getAllCapitalization($ignoreCache = false)
    {
        if (!$ignoreCache) {
            $caps = Cache::read('caps', 'short');
        } else {
            $caps = false;
        }

        if (!$caps) {
            $caps = [];
            foreach (self::CURRENCIES as $CURRENCY) {
                $cap = json_decode(file_get_contents(self::API_URL . $CURRENCY . '/'), true)[0];
                $caps[$cap['id']] = $cap;
            }

            $caps = array_merge($caps, Payment::getUsdPriceArrayAll());

            Cache::write('caps', $caps, 'short');
        }

        return empty($caps) ? [] : $caps;
    }

    /**
     * Converts USD to token
     * @param $usd
     * @param $currency
     * @param $decimalsNumber
     * @return float|int
     */
    static public function usd2token($usd, $currency, $decimalsNumber = null)
    {

        if ($currency === 'USD') {
            return $usd;
        }
        $cap = self::getAllCapitalization();
        if (!isset(self::SHORT_LONG[$currency]) || !isset($cap[self::SHORT_LONG[$currency]]['price_usd'])) {
            throw new \Exception('Incorrect currency');
        }
        $usdPrice = $cap[self::SHORT_LONG[$currency]]['price_usd'];
        $result = $usd / $usdPrice;

        if($decimalsNumber && is_int($decimalsNumber)){
            $result = sprintf('%.'.$decimalsNumber.'f', $result);
        }

        return $result;
    }

    /**
     * Converts token to usd
     * @param $token
     * @param $currency
     * @return float|int
     */
    static public function token2usd($token, $currency)
    {
        if ($currency === 'USD') {
            return $token;
        }
        $cap = self::getAllCapitalization();
        if (!isset(self::SHORT_LONG[$currency]) || !isset($cap[self::SHORT_LONG[$currency]]['price_usd'])) {
            throw new \Exception('Incorrect currency');
        }
        $usdPrice = $cap[self::SHORT_LONG[$currency]]['price_usd'];

        return $token * $usdPrice;
    }
}