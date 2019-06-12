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
 * ERC20 Token
 * @package App\Lib\Tokens
 */
class  ERC20 extends Token
{

    const SERVICE_PATH = ROOT . DS . 'service' . DS . 'eth' . DS;
    const SP = self::SERVICE_PATH;

    const DISABLED = false;

    /**
     * Get account ETH balance
     * @param string $account
     * @return string
     * @throws \Exception
     */
    static function getBalance($account)
    {
        $temp = exec('node ' . self::SERVICE_PATH . 'main.js balance ' . $account, $data, $returnVar);

        if ($returnVar === 0) {
            return ($temp);
        }

        throw new \Exception($temp);
    }


    /**
     * Get token balance in configured contract
     * @param string $account
     * @param string $contractAddress
     * @return string
     * @throws \Exception
     */
    static function getTokenBalance($account, $contractAddress = false)
    {
        if (empty($contractAddress)) {
            $contractAddress = Configure::read('App.erc20.contract');
        }
        if (empty($contractAddress)) {
            throw new \Exception('Error: Empty contract address');
        }
        $temp = exec('node ' . self::SERVICE_PATH . 'main.js --contract ' . $contractAddress . ' balanceOf ' . $account, $data, $returnVar);

        if ($returnVar === 0) {
            return ($temp);
        }

        throw new \Exception($temp);
    }

    /**
     * Transfer to account
     * @param string $toAccount
     * @param float $amount
     * @param bool $contractAddress
     * @param array $account
     * @return bool|mixed
     * @throws \Exception
     */
    static function transfer($toAccount, $amount, $contractAddress = false, $account = [])
    {
        if (empty($contractAddress)) {
            $contractAddress = Configure::read('App.erc20.contract');
        }

        if (empty($contractAddress)) {
            throw new \Exception('Error: Empty contract address');
        }

        if (empty($account)) {
            $account = Configure::read('App.erc20.account');
        }

        if (empty($account)) {
            throw new \Exception('Error: Empty account');
        }

        if (empty($account['address']) || empty($account['private'])) {
            throw new \Exception('Error: Empty account address or private key');
        }

        if (empty(Configure::read('App.erc20.gasPrice')) || empty(Configure::read('App.erc20.gasLimit'))) {
            throw new \Exception('Error: Empty gas price or gas limit');
        }


        $temp = exec('node ' . self::SERVICE_PATH . 'main.js --gasPrice ' . Configure::read('App.erc20.gasPrice') . '  --gasLimit ' . Configure::read('App.erc20.gasLimit') . '  --contract ' . $contractAddress . ' --address ' . $account['address'] . ' --private ' . $account['private'] . ' transfer ' . $toAccount . ' ' . $amount, $data, $returnVar);

        if ($returnVar === 0) {
            return json_decode(implode(' ', $data), true);
        }

        throw new \Exception(implode(' ', $data));

    }

    /**
     * Tile in admin interface
     */
    public static function drawAdminTile()
    {
        if (strpos(self::getClass(), 'ERC20') === false) {
            return;
        }
        $account = Configure::read('App.erc20.account');

        ?>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">ERC20 Token</h3>
                </div>
                <div class="box-body" style="overflow-x: scroll">
                    <b>Contract address: </b><span><?= h(Configure::read('App.erc20.contract')) ?></span><br>
                    <b>Sender address: </b><span><?= h($account['address']) ?></span><br>
                    <b>Gas price: </b><span><?= h(Configure::read('App.erc20.gasPrice')) ?></span><br>
                    <b>Gas limit: </b><span><?= h(Configure::read('App.erc20.gasLimit')) ?></span><br>
                </div>
            </div>
        </div>
        <?php
    }
}