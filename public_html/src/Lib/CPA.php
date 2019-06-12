<?php

namespace App\Lib;


use App\Model\Table\TransactionsTable;
use App\Model\Table\UsersTable;

class CPA
{
    const API_KEY = '380c7ebe198316a36be391c4cdaec231';
    const API_URL_CLOED = 'http://offers.cloed.affise.com/postback?secure=' . self::API_KEY;

    const API_URL_ADCOMBO = 'https://notify.adcombo.com/aln/';

    const CPA_PAY = 'CPA_PAY';
    const CPA_REGISTER = 'CPA_REGISTER';
    const CPA_NEW_ORDER = 'CPA_NEW_ORDER';
    const CPA_CONFIRM = 'CPA_CONFIRM';
    const CPA_LOGIN = 'CPA_LOGIN';


    /**
     * Cloed request
     * @param int $clickId
     * @param string $goal
     * @param array $params
     * @return bool|array
     */
    public static function request($clickId, $goal, $params = [])
    {
        try {
            $result['cloed'] = self::cloed($clickId, $goal, $params);
            $result['adcombo'] = self::adcombo($clickId, $params);

            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * Cloed request
     * @param int $clickId
     * @param string $goal
     * @param array $params
     * @return bool|array
     */
    public static function cloed($clickId, $goal, $params = [])
    {
        return;
        try {
            $implodedParams = '';
            foreach ($params as $param => $value) {
                $implodedParams .= '&' . $param . '=' . urlencode($value);
            }
            $url = self::API_URL_CLOED . '&clickid=' . $clickId . '&goal=' . $goal . $implodedParams;

            return json_decode(file_get_contents($url), true) + ['url' => $url];
        } catch (\Exception $e) {
            return [];
        }
    }


    /**
     * @param $clickId
     * @param $params
     * @return array
     */
    public static function adcombo($clickId, $params)
    {
        return;
        try {

            $implodedParams = '';
            foreach ($params as $param => $value) {
                $implodedParams .= '&' . $param . '=' . urlencode($value);
            }
            $url = self::API_URL_ADCOMBO . '?esub=' . $clickId . $implodedParams;
            debug($url);
            @$req = [file_get_contents($url)];

            return $req;
        } catch (\Exception $e) {
            return [];
        }
    }


    /**
     * CPA register hook
     * @param int $clickId
     * @param int $userId
     */
    public static function register($clickId, $userId)
    {
        Sandbox::runFromStorageOrIgnore(self::CPA_REGISTER, ['clickId' => $clickId, 'userId' => $userId]);
    }


    /**
     * CPA order hook
     * @param int $clickId
     * @param int $userId
     * @param int $amount
     * @param string $currency
     */
    public static function newOrder($clickId, $userId, $amount, $currency)
    {
        Sandbox::runFromStorageOrIgnore(self::CPA_NEW_ORDER, [
            'clickId'  => $clickId,
            'userId'   => $userId,
            'amount'   => $amount,
            'currency' => $currency,
        ]);
    }

    /**
     * CPA pay hook
     * @param int $clickId
     * @param int $userId
     * @param float $amount
     * @param string $currency
     * @param int $transactionId
     * @param int $tokenAmount
     */
    public static function pay($clickId, $userId, $amount, $currency, $transactionId, $tokenAmount)
    {
        Sandbox::runFromStorageOrIgnore(self::CPA_PAY, [
            'clickId'       => $clickId,
            'userId'        => $userId,
            'currency'      => $currency,
            'amount'        => $amount,
            'transactionId' => $transactionId,
            'tokenAmount' => $tokenAmount
        ]);

        $user = UsersTable::instance()->get($userId);
        $transaction = TransactionsTable::instance()->get($transactionId);
        if(in_array($transaction->type, ['TOKEN_BUY'])){
            $tokenCount = abs($transaction->amount);
            Emails::receiptFunds($user->email, $tokenCount, $amount, $currency);
        }
    }

    /**
     * CPA email confirm
     * @param int $clickId
     * @param int $userId
     * @param int $refUser
     */
    public static function confirm($clickId, $userId, $refUser)
    {
        Sandbox::runFromStorageOrIgnore(self::CPA_CONFIRM, [
            'clickId' => $clickId,
            'userId'  => $userId,
            'refUser' => $refUser,
        ]);
    }

    /**CPA login hook
     * @param $clickId
     * @param $userId
     */
    public static function login($clickId, $userId)
    {
        Sandbox::runFromStorageOrIgnore(self::CPA_LOGIN, [
            'clickId'   => $clickId,
            'userId'    => $userId,
            'loginInfo' => Misc::getUserLastLogin($userId),
        ]);
    }
}