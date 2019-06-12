<?php


class BitcoinValve
{
    const BITCOINVALVE_URL = 'http://btcvalve.izzz.io/';

    /**
     * Request to Bitcoinway node
     * @param array $data
     * @return bool|mixed
     */
    private static function request($action, $data = [])
    {
        $url = self::BITCOINVALVE_URL . $action;


        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        if ($result === false) { /* Handle error */
            return false;
        }

        return json_decode($result, true);
    }


    /**
     * Creates deposit address on BitcoinValve
     * @param string $callback, address for send callback
     * @return array
     * @throws Exception
     */
    public static function createDeposit($callback)
    {
        $data = [
            'callback_addr' => $callback,
        ];

        $result = self::request('new', $data);
        if (!$result) {
            throw new Exception('Bitcoinway general error');
        }

        return $result;
    }
}