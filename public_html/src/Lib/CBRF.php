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

use Cake\Cache\Cache;

/**
 * Russian Central Bank
 * @package App\Lib
 */
class CBRF
{

    const API_URL = 'https://www.cbr-xml-daily.ru/daily_json.js';


    /**
     * Gets courses
     * @return array
     */
    static public function getAllCapitalization()
    {
        $capital = json_decode(file_get_contents(self::API_URL), true)['Valute'];

        return $capital;
    }

    /**
     * Converts USD to token
     * @param $usd
     * @param $currency
     * @return float|int
     */
    static public function rur2currency($usd, $currency)
    {

        if ($currency === 'RUR') {
            return $usd;
        }
        $cap = self::getAllCapitalization();
        $rurPrice = $cap[$currency]['Value'];

        return $usd / $rurPrice;
    }


    /**
     * Converts token to usd
     * @param $token
     * @param $currency
     * @return float|int
     */
    static public function currency2rur($token, $currency)
    {
        if ($currency === 'RUR') {
            return $token;
        }
        $cap = self::getAllCapitalization();
        $rurPrice = $cap[$currency]['Value'];

        return $token * $rurPrice;
    }

    /**
     * Converts usd to eur
     * @param $amount
     * @return float|int

     */
    public static function usd2eur($amount)
    {
        $cap = self::getAllCapitalization();

        $usdPrice = $cap['USD']['Value'];
        $eurPrice = $cap['EUR']['Value'];

        return ($amount * $usdPrice)  / $eurPrice;
    }
}