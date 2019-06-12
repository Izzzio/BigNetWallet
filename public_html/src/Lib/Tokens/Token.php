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

namespace App\Lib\Tokens;

use Cake\Core\Configure;


/**
 * Token abstract
 * @package App\Lib\Tokens
 */
class  Token
{

    const DISABLED = true;


    /**
     * Returns class
     * @return \App\Lib\Tokens\ERC20
     */
    public static function getClass()
    {
        $tokenType = Configure::read('App.tokenType');

        $class = '\\App\\Lib\\Tokens\\' . str_replace('.php', '', $tokenType);

        return $class;
    }

    /**
     * Get Account balance
     * @param string $account
     * @return float
     */
    public static function getBalance($account)
    {
        $class = self::getClass();
        /**
         * @var \App\Lib\Tokens\ERC20 $class
         */
        if (!$class::DISABLED) {
            return $class::getBalance($account);
        } else {
            throw new \Exception($class . ' is disabled!');
        }
    }

    /**
     * Transfer token to account
     * @param string $toAccount
     * @param float $amount
     * @return bool
     */
    public static function transfer($toAccount, $amount)
    {
        $class = self::getClass();
        /**
         * @var \App\Lib\Tokens\ERC20 $class
         */
        if (!$class::DISABLED) {
            return $class::transfer($toAccount, $amount);
        } else {
            throw new \Exception($class . ' is disabled!');
        }
    }

    /**
     * Get Account Token balance
     * @param string $account
     * @return float
     */
    public static function getTokenBalance($account)
    {
        $class = self::getClass();
        /**
         * @var \App\Lib\Tokens\ERC20 $class
         */
        if (!$class::DISABLED) {
            return $class::getTokenBalance($account);
        } else {
            throw new \Exception($class . ' is disabled!');
        }
    }


}