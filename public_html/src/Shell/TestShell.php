<?php

namespace App\Shell;

use App\Lib\KeyValue;
use App\Lib\Tokens\ERC20;
use App\Lib\Tokens\Token;
use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use App\Model\Table\TransactionsTable;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Web3\Contract;
use Web3\Eth;
use Web3\Web3;

class TestShell extends Shell
{

    /**
     * @param string $appConfig Configuration used to go
     */
    public function main($appConfig = null)
    {

        if (empty($appConfig)) {
            echo "No configuration specified!\n\n";
        } else {
            Configure::load('cabinets/' . $appConfig, 'default', true);
            ConnectionManager::drop('default');
            ConnectionManager::drop('test');
            ConnectionManager::config(Configure::consume('Datasources'));
        }


        $eth = Token::transfer('0x99aAF86cbd49518a761B7d410e1D195B3B88cAbA', 2.1);

        var_dump($eth);

    }


}
