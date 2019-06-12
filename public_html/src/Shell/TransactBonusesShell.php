<?php

namespace App\Shell;

use App\Lib\Csv;
use App\Lib\UserUtils;
use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;


class TransactBonusesShell extends Shell
{
    /**
     * @param string $appConfig Configuration used to go
     */
    public function main($appConfig, $bonusesCsv)
    {

        if (empty($appConfig)) {
            echo "No configuration specified!\n\n";
        } else {
            Configure::load('cabinets/' . $appConfig, 'default', true);
            ConnectionManager::drop('default');
            ConnectionManager::drop('test');
            ConnectionManager::config(Configure::consume('Datasources'));
        }

        $csv = new Csv();
        $data = $csv->createAssocArrayFromCsv($bonusesCsv);

        if (empty($data[0]['bonus'])) {
            throw new \Exception("Can't determine bonus field");
        }

        if (empty($data[0]['email']) && empty($data[0]['id'])) {
            throw new \Exception("Can't determine email or id field");
        }

        $fieldName = 'email';
        if (empty($data[0]['email'])) {
            $fieldName = 'id';
        }

        echo "Using key field: " . $fieldName . "\n";

        foreach ($data as $userBonus) {
            /**
             * @var User $user
             */
            $user = UsersTable::f()->where([$fieldName => $userBonus[$fieldName]])->first();
            if (empty($user)) {
                echo "Error: User with ${fieldName} " . $userBonus[$fieldName] . " not found!\n";
                continue;
            }

            try {
                UserUtils::transactTokens($user->id, $userBonus['bonus'], 'TransactBonusesShell');
            } catch (\Exception $e) {
                echo 'Error:' . $e->getMessage() . "\n";
                continue;
            }

            echo "Success: Bonus for user " . $userBonus[$fieldName] . " updated\n";
        }


        //var_dump($data);

    }
}