<?php

namespace App\Shell;

use App\Lib\KeyValue;
use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use App\Model\Table\TransactionsTable;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

class ExportUsersShell extends Shell
{
    const GOOGLE_PRIVATE_KEY = "-----BEGIN PRIVATE KEY-----\nMIIEuwIBADANBgkqhkiG9w0BAQEFAASCBKUwggShAgEAAoIBAQCzpiSZW1UjDkSw\nEM0bQv4yEkHPpX2K6ohaWfWbTAtDOj5yq/yjUI5J8s4ug27DZhbORKmWb3g1xaGk\nxl3/cWhrk/SjIABYy/Cz2kFpSt3vziEkm2Foe5NLpHyxnKcNJASNHnM1s1c9y7Li\ndFAy/LJqCsnPSk5uj3K7HmabIebQN32/RGjxKsM6SiHHNIHzTgMtgBDbfmOqC3aF\nsjMSwCyPIi4RjWMW8C83KcYZ/9exs+KO5nq+FE4w0ea3g+70Pta1bSrJG/s0gbH9\nWkd2owjkMKv6BZ1aA8AcCFcjJpD13qJOFKWUZ+9sJ8P74vJbCmnuFyCsXdLY+YLp\n4Bs8XHETAgMBAAECggEAAL9Xi6PLo40IUCCMbz6aHCSN+DUyDoU8nVOefU+VrxPr\nn+0t7JKwj4eJFWcf64QzOBclCtEv6Nlc+3iFJO5DMZ9jTIJyPexV9gmZwrxjAVUU\nN44bRk9X+jVBp44v9mgIn3sESQbpUq0pngjp2dcfTuhN6qTegACXc5vZcBp2AWEX\n7xVM3ZOmu/Dnm66H7xXckr7QmqLEDozabjHLrXO/LEGtZ1Ut2Y51V7c78o3szDIp\nX8YjlnAG+EmLBjSIHBQWgkm2aXRuC6w2YLneR8/tImP2nZgroL9y/v4+8pykP928\n/Rl2UUJvc3yEWIfT0zSSfxFOmORqI31N7znAOGLR0QKBgQDpIaxj8T3qIMea9zqv\n/ZgO3Kec9xe7mSoaXQhEBWvMUlT9+rPkjFYBvhw/5obl3zw3qU2J4KqN9zQPfSM8\nNYt07joyETvF9ZrK+ohZ5xPZNNGD0RGW5ylil/utDQ2yf47pfVjnDZBRcC2tQdQh\nLlfWtlKPmjuVwJYTn7jgXzDmlQKBgQDFRW7B1EBt0x7NncWanQXELR3qFI/xUH7L\n1xUV8HO1/CjkB+gILa1c4QoVvArEBEQewH/grPQCRue4KyWQ/5xMJODx/TArIn5T\nqlWtZC1HzGKX/QboKxzz8kvwAnQR78A11pG6uDV2n/9A7njjm7zeqn7HVqkYQZiN\ndkNKYiPXBwKBgQCxD+ktkvjyTGktkl4ZcmK9zuritWxqB/9JPKVdfDyOV23D5Fgi\n2k8sTaaJBd4o0q6am9SPRnpjDoCUzvcm8If1jEXY5uveAxbI2RUcKvwROSNzmSNh\n2Dm/by0wFrzzeBwjzBbsjYmxwKCAeYHSna8LHTiBZqOgrj+Nsf6pMsMiLQJ/LwFc\nYtMwhvrHXDc73puLxDL77cr4gYesruWRIKkq6TIsjClWIJzBsl/tB0DHT+20TZ+Q\n2PhdLC25CSk+yk4d8AbZks/BqoWNlGICCE7We0U4OP8RpkCfpYEWlxn+jkeShUGb\nd+Js2tdE+zPXmmSBnI0DqHv9zsnSj+KeJhs8bwKBgBd3LmGm9XZl0mQMI7bwEW2I\nQHCTyS8KDYkvqAiThfC5CtI9xt5tQxrIzkJcD4uiD4OWOBqP6rKuJIBI2QDzOQdw\nSdfUIeEJxwxImuB6YaYTXfKzQWygqbNPdYYzZxSy3S81+T7L9fOlQucc6sD0sv7C\nTGdEyK+yYodqYTCVE/MO\n-----END PRIVATE KEY-----\n";

    private $_service;

    private $_spreadsheetId;

    private $_transactionsData;

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

        $users = $this->_getUsers();
        $usersArray = $this->_createUsersArray($users);

        $updateData = $this->_updateSpreadsheet($usersArray);

        $this->out('added ' . $updateData . ' rows.');
    }


    /**
     * Get users
     *
     * @return mixed
     */
    private function _getUsers()
    {
        return UsersTable::instance()->f()
            ->group(['Users.id'])
            ->autoFields(true);
    }

    /**
     * Connect to Google Spreadsheet and set the worksheet
     */
    private function _getWorksheet()
    {
        $accessToken = $this->_getToken();

        $client = new \Google_Client();
        $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);
        $client->setAccessToken($accessToken);
        $client->setApplicationName(Configure::read('App.spreadsheet.name'));
        $client->setAccessType('offline');

        $this->_service = new \Google_Service_Sheets($client);
        $this->_spreadsheetId = Configure::read('App.spreadsheet.spreadsheetId');
    }

    /**
     * Authorize and create access token
     *
     * @return mixed
     */
    private function _getToken()
    {
        $client_email = "users-spreadsheet@agile-terra-200108.iam.gserviceaccount.com";
        $scope = "https://www.googleapis.com/auth/spreadsheets";

        $jwtHeader = $this->_base64url_encode(json_encode([
            "alg" => "RS256",
            "typ" => "JWT",
        ]));

        //{Base64url encoded JSON claim set}
        $jwtClaim = $this->_base64url_encode(json_encode([
            "iss"   => $client_email,
            "scope" => $scope,
            "aud"   => "https://www.googleapis.com/oauth2/v4/token",
            "exp"   => time() + 3600,
            "iat"   => time(),
        ]));

        //The base string for the signature: {Base64url encoded JSON header}.{Base64url encoded JSON claim set}
        $success = openssl_sign(
            $jwtHeader . "." . $jwtClaim,
            $jwtSig,
            self::GOOGLE_PRIVATE_KEY,
            "sha256WithRSAEncryption"
        );

        $jwtSign = $this->_base64url_encode($jwtSig);
        $jwtAssertion = $jwtHeader . "." . $jwtClaim . "." . $jwtSign;

        $url = 'https://www.googleapis.com/oauth2/v4/token';
        $data = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwtAssertion,
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $accessToken = json_decode($result)->{"access_token"};

        return $accessToken;
    }

    /**
     * Update and insert data to spreadsheet.
     * Returns number of added rows
     *
     * @param $usersArray
     * @param $spreadsheetValues
     * @return int
     */
    private function _updateSpreadsheet($usersArray)
    {
        $range = 'A2:R';
        $addedRows = 0;
        $insertValues = [];

        $this->_getWorksheet();

        foreach ($usersArray as $user) {
            $insertValues[] = [
                $user['userid'],
                strtolower($user['email']),
                $user['verified'],
                strpos($user['name'], '@') !== false ? '' : $user['name'],
                $user['surname'],
                $user['fullname'],
                $user['case'],
                $user['companyname'],
                $user['phone'],
                $user['country'],
                $user['tokens'],
                $user['representativename'],
                $user['birthdate'],
                $user['usd'],
                $user['btc'],
                $user['eth'],
                $user['cid'],
                'TRUE',
            ];

            $addedRows += 1;
        }

        if (count($insertValues)) {
            $updateBody = new \Google_Service_Sheets_ValueRange([
                'range'          => $range,
                'majorDimension' => 'ROWS',
                'values'         => $insertValues,
            ]);

            $this->_service->spreadsheets_values->update(
                $this->_spreadsheetId,
                $range,
                $updateBody,
                ['valueInputOption' => 'USER_ENTERED']
            );
        }

        return $addedRows;
    }

    /**
     * Select list of user's properties to array
     *
     * @param $users
     * @return array
     */
    private function _createUsersArray($users)
    {
        $usersArray = [];
        $this->_transactionsData = TransactionsTable::instance()
            ->f();

        foreach ($users as $user) {
            $userData = json_decode($user->registration_data, true);
            $transactionsData = $this->_getTransactionsData($user->id);

            /*debug($transactionsData);
            die;*/

            if (isset($userData['birthdate'])) {
                $birthdate = $userData['birthdate'];
            } elseif (isset($userData['representative_birthdate'])) {
                $birthdate = $userData['representative_birthdate'];
            } else {
                $birthdate = '';
            }

            $row = [
                'userid'             => $user->id,
                'email'              => isset($user->email) ? $user->email : '',
                'verified'           => $user->status == User::STATUS_VERIFIED ? 'Yes' : 'No',
                'name'               => isset($user->name) ? $user->name : '',
                'surname'            => isset($userData['surname']) ? $userData['surname'] : '',
                'fullname'           => isset($userData['fullname']) ? $userData['fullname'] : '',
                'case'               => isset($userData['case']) ? $userData['case'] : '',
                'companyname'        => isset($userData['company_name']) ? $userData['company_name'] : '',
                'phone'              => isset($userData['phone']) ? $userData['phone'] : '',
                'country'            => isset($userData['country']) ? $userData['country'] : '',
                'tokens'             => isset($user->tokens) ? $user->tokens : '',
                'usd'                => $transactionsData['usd'],
                'btc'                => $transactionsData['btc'],
                'eth'                => $transactionsData['eth'],
                'representativename' => isset($userData['representative_name']) ? $userData['representative_name'] : '',
                'birthdate'          => $birthdate,
                'cid'                => KeyValue::read($user->id . '_cid', ''),
            ];

            $usersArray[] = $row;
        }

        return $usersArray;
    }

    /**
     * Get USD, BTC and ETH transactions
     *
     * @param $userId
     * @return array
     */
    private function _getTransactionsData($userId)
    {
        return [
            'usd' => floatval(TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('usd')])->where([
                'user_id' => $userId,
                'usd > 0',
            ])->first()->sum),
            'btc' => floatval(TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('amount')])->where([
                'user_id'  => $userId,
                'amount > 0',
                'currency' => 'BTC',
            ])->first()->sum),
            'eth' => floatval(TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('amount')])->where([
                'user_id'  => $userId,
                'amount > 0',
                'currency' => 'ETH',
            ])->first()->sum),
        ];


    }

    /**
     * @param $data
     * @return string
     */
    private function _base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

}
