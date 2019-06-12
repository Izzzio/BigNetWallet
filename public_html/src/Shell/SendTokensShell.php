<?php

namespace App\Shell;

use App\Lib\KeyValue;
use App\Lib\Tasker;
use App\Lib\Tokens\ERC20;
use App\Lib\Tokens\Token;
use App\Model\Entity\Task;
use App\Model\Entity\User;
use App\Model\Table\LogTable;
use App\Model\Table\UsersTable;
use App\Model\Table\TransactionsTable;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Web3\Contract;
use Web3\Eth;
use Web3\Web3;

class SendTokensShell extends Shell
{

    const TASKS_MODULE = 'SendTokens';

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

        echo "Start date " . date('Y-m-d H:i:s') . "\n";

        $tasks = Tasker::getTasksInWork(self::TASKS_MODULE);

        foreach ($tasks as $task) {
            $user = UsersTable::instance()->get($task->params['user']);
            $amount = $task->params['amount'];

            if (empty($amount)) {
                $amount = $user->tokens - $user->in_chain;
            }

            echo "Send tokens of " . $user->id . "(" . $user->email . ") " . $amount . "\n";

            if ($amount > $user->tokens - $user->in_chain || $amount <= 0) {
                echo "Error: User  " . $user->id . " insufficient funds\n";
                LogTable::write('SEND_TOKENS_INSUFFICIENT_FUNDS', $user, $user->id);
                //Tasker::setTasksNew([$task]);
                continue;
            }

            try {
                $transfer = Token::transfer($user->wallet, $amount);
                LogTable::write('SEND_TOKENS_TRANSACTION', $transfer, $user->id);
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage() . "\n";
                LogTable::write('SEND_TOKENS_ERROR', $e->getMessage(), $user->id);
                //Tasker::setTasksNew([$task]);
                continue;
            }

            //$user->tokens -= $amount;
            $user->in_chain += $amount;

            if (!UsersTable::instance()->save($user)) {
                echo "Error: Update  " . $user->id . " balance\n";
                LogTable::write('SEND_TOKENS_UPDATE_ERROR', $user, $user->id);
                //Tasker::setTasksNew([$task]);
                continue;
            }

            Tasker::setTasksFinished([$task]);
        }


    }

    /**
     * Add transfer Taks
     * @param int $userId
     * @param float $amount
     * @return Task
     */
    public static function addTransfer($userId, $amount = false)
    {
        return Tasker::addTask(self::TASKS_MODULE,
            [
                'user'   => $userId,
                'amount' => $amount,
            ]);
    }


}