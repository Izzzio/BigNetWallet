<?php

namespace App\Lib;

use App\Model\Table\TransactionsTable;
use App\Model\Table\UsersTable;
use Cake\Core\Exception\Exception;

class UserUtils
{
    /**
     * Creates token transaction for user
     * @param int $userId
     * @param float $amount
     * @param string $comment
     * @return \App\Model\Entity\User
     * @throws \Exception
     */
    public static function transactTokens($userId, $amount, $comment)
    {
        $amount = floatval($amount);
        $user = UsersTable::instance()->get($userId);
        if (empty($amount)) {
            throw  new \Exception('Incorrect amount');
        }

        $amountInUSD = Calculator::token2Usd($amount);
        $money['BTC'] = CoinMarketCap::usd2token($amountInUSD, 'BTC', 10);
        $money['ETH'] = CoinMarketCap::usd2token($amountInUSD, 'ETH', 10);

        $transaction = TransactionsTable::instance()->newEntity([
            'amount'   => -$amount,
            'currency' => 'Manual',
            'user_id'  => $userId,
            'usd'      => 0,
            'rawdata'  => $comment,
            'currencys_rate'    => @json_encode($money, JSON_UNESCAPED_UNICODE),
        ]);


        $user->tokens += $amount;

        if (!UsersTable::instance()->save($user)) {
            throw  new \Exception('User saving error ' . print_r($user, true));
        }

        if (!TransactionsTable::instance()->save($transaction)) {
            throw  new \Exception('Transaction saving error ' . print_r($transaction, true));
        }

        return $user;
    }
}