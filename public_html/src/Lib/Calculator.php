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

use App\Model\Table\UsersTable;
use Cake\Core\Configure;


class Calculator
{
    /**
     * Return token price
     * @return mixed
     */
    public static function getTokenCurrencyPrice()
    {
        return Configure::read('App.calculator.tokenCurrencyPrice');
    }

    public static function getPeriods()
    {
        return Configure::read('App.calculator.periods');
    }

    public static function getPeriodSales()
    {
        return Configure::read('App.calculator.periodSales');
    }

    /**
     * Return period
     * @param string $curentDate Date in Y-m-d H:i format
     * @return bool|int
     */
    public static function getPeriod($curentDate = null)
    {
        if (empty($curentDate)) {
            $curentDate = date('Y-m-d H:i');
        }
        foreach (self::getPeriods() as $index => $PERIOD) {
            if ($PERIOD['end'] > $curentDate && $PERIOD['start'] <= $curentDate) {
                return $index;
            }
        }

        return false;
    }


    /**
     * Converts usd to token
     * @param float $usd
     * @throws \Exception
     * @return float
     */
    public static function usdToToken($usd)
    {
        $result = Sandbox::runFromStorageOrIgnore('usdToToken', ['usd' => $usd]);
        if ($result !== false) {
            return $result;
        }

        return $usd / CoinMarketCap::token2usd(self::getTokenCurrencyPrice(), Misc::internalCurrency());

    }

    /**
     * Return token bonus for date
     * @param float $tokens
     * @param null|string $date
     * @param int $userId
     * @return int
     */
    public static function getTokenBonus($tokens, $date = null, $userId = null)
    {
        $personalBonus = 0;
        if (!empty($userId)) {
            $user = UsersTable::instance()->get($userId);
            $personalBonus = $user->personal_bonus;
            if (!empty($user->ref_user)) {
                $refUser = UsersTable::instance()->get($user->ref_user);
                $personalBonus += $refUser->bonus_for_referals;
            }

            if (empty($personalBonus)) {
                $personalBonus = 0;
            }
        }

        $query = UsersTable::instance()->f();
        $soldTokensAmount = $query->select(['sum' => $query->func()->sum('tokens')])->first()->sum;
        $bonus = Sandbox::runFromStorageOrIgnore('getTokenBonus', ['bonusDate'   => $date,
                                                                   'tokens'      => $tokens,
                                                                   'sold_tokens' => $soldTokensAmount,
                                                                   'userId' => $userId,
        ]);
        if ($bonus !== false) {
            return $bonus + $personalBonus;
        }

        $period = self::getPeriod($date);
        $convertTable = self::getPeriodSales()[$period];
        if (empty($convertTable)) {
            return 0;
        }
        $tokens = round($tokens, 2);
        foreach ($convertTable as $bonus => $filter) {
            if ($tokens >= $filter['min'] && $tokens <= $filter['max']) {
                return $bonus + $personalBonus;
            }
        }

        return 0;
    }

    /**
     * Just percent calc, but useful for showing to user
     * @param float $tokens
     * @param float $bonus
     * @return float
     */
    public static function extractBonusTotal($tokens, $bonus)
    {
        return $tokens * ($bonus / 100);
    }

    /**
     * Converts USD to token with bonus
     * @param float $usd
     * @param string|null $date
     * @param  int $userId
     * @return float
     */
    public static function usdToTokenSale($usd, $date = null, $userId)
    {
        $tokens = self::usdToToken($usd);
        $bonus = self::getTokenBonus($tokens, $date, $userId);
        $tokenBonus = self::extractBonusTotal($tokens, $bonus);

        return $tokens + $tokenBonus;

    }

    /**
     * Converts tokens to USD
     * @param $tokens
     * @return int
     */
    public static function token2Usd($tokens)
    {
        $result = Sandbox::runFromStorageOrIgnore('token2Usd', ['tokens' => $tokens]);
        if ($result !== false) {
            return $result;
        }

        return $tokens * CoinMarketCap::token2usd(self::getTokenCurrencyPrice(), Misc::internalCurrency());
    }

    /**
     * Returns bonus ratio
     * @param $usd
     * @param $tokens
     * @return float|int
     */
    public static function calcTokenRatio($usd, $tokens)
    {
        return $tokens / $usd;
    }

    /**
     * Return complex bonus data
     * @param $usd
     * @param null $date
     * @param $userId
     * @return array - Complex info (in tokens)
     */
    public static function getComplexUsd2Token($usd, $date = null, $userId)
    {
        $tokenAmountNoBonus = self::usdToToken($usd);
        $bonus = self::getTokenBonus($tokenAmountNoBonus, $date, $userId);
        $bonusAmount = self::extractBonusTotal($tokenAmountNoBonus, $bonus);
        $total = self::usdToTokenSale($usd, $date, $userId);

        return compact('bonus', 'bonusAmount', 'total', 'currency');
    }

}