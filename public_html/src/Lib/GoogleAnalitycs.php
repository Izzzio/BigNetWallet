<?php

namespace App\Lib;


class GoogleAnalitycs
{

    const API_URL = 'https://www.google-analytics.com/collect';


    /**
     * GA request
     * @param array $params
     * @throws \Exception
     * @return string
     */
    public static function request($params = [])
    {
        try {

            $params = [
                    'tid' => Misc::tcfg('ga'),
                    'v'   => '1',
                    't'   => 'event',
                    'ni'  => '1',
                ] + $params;

           // var_dump(self::API_URL . '?' . http_build_query($params));


            return file_get_contents(self::API_URL . '?' . http_build_query($params));
            /*  return $http->post(self::API_URL, [
                      'tid' => self::TID,
                      'v'   => '1',
                      't'   => 'event',
                  ] + $params)->body();*/
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}