<?php


class EtherValve
{
    const ETHERVALVE_URL = 'http://ethervalve.izzz.io/';

    /**
     * Request to Etherway node
     * @param array $data
     * @return bool|mixed
     */
    private static function request($action, $data = [])
    {
        $url = self::ETHERVALVE_URL . $action;


        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
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
     * Creates deposit address on EtherValve
     * @param string $callback
     * @param string $backAddress
     * @return array
     * @throws Exception
     */
    public static function createDeposit($callback, $backAddress)
    {
        $data = [
            'callback' => $callback,
            'address'  => $backAddress,
        ];

        $result = self::request('new', $data);
        if (!$result) {
            throw new Exception('Etherway general error');
        }

        return $result;
    }
}