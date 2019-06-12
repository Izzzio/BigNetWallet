<?php

namespace App\Lib;

use App\Controller\Component\IndianAuthComponent;
use Cake\Core\Configure;
use Cake\Utility\Security;


/**
 * Encryptor
 * @package App\Lib
 */
class Crypt
{

    /**
     * Encryptor/Decryptor
     * @param $string
     * @param string $action
     * @return bool|string
     */
    private static function _cryptDecrypt($string, $action = 'e')
    {
        $secret_key = Security::salt();
        $secret_iv = IndianAuthComponent::makeHash(Security::salt());

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else {
            if ($action == 'd') {
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }
        }

        return $output;
    }


    /**
     * Enc string
     * @param $string
     * @return string
     */
    public static function ecrypt($string)
    {
        return static::_cryptDecrypt($string, 'e');
    }

    /**
     * Decryption
     * @param $string
     * @return string
     */
    public static function dcrypt($string)
    {
        return static::_cryptDecrypt($string, 'd');
    }

}