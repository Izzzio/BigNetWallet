<?php

namespace App\Lib\Payments;


use Cake\Core\Configure;

class Payment
{
    const NAME = 'AbstractPayment';
    const DISABLED = true;
    const CACHE_CONFIG = 'payment';
    const DEPOSIT_CACHE_CONFIG = 'deposit';
    const DEFAULT_GATE = 'CoinPayments';

    /**
     * Return correct IPN URL
     * @return string
     */
    public static function getIPNUrl()
    {
        if (empty(URL_PREFIX)) {
            return BASE_PROTOCOL . '://' . BASE_DOMAIN . '/Payment/process/' . static::NAME . '';
        }

        return URL_PREFIX . '/Payment/process/' . static::NAME . '';
    }


    /**
     * @deprecated Do not use create transaction
     * @param $amount
     * @param $currency
     * @param $invoice
     * @param array $additions
     */
    public static function createTransaction($amount, $currency, $invoice, $additions = [])
    {
    }

    /**
     * Created deposit by payments configuration
     * @param $amount
     * @param $currency
     * @param $invoice
     * @param array $additions
     * @throws \Exception
     * @return array
     */
    public static function createDeposit($amount, $currency, $invoice, $additions = [])
    {
        $gatesConfig = Configure::read('App.paymentGates');

        $gate = self::DEFAULT_GATE;
        if (isset($gatesConfig[$currency])) {
            $gate = $gatesConfig[$currency];
        }

        $class = '\\App\\Lib\\Payments\\' . str_replace('.php', '', $gate);

        /**
         * @var \App\Lib\Payments\CoinPayments $class
         */
        if (!$class::DISABLED) {
            return $class::createDeposit($amount, $currency, $invoice, $additions);
        } else {
            throw new \Exception($gate . ' is disabled!');
        }

    }

    /**
     * Обработка платежа
     * @param $request
     * @param $invoice
     */
    public static function processPayment($request, $invoice)
    {
    }

    /**
     * Отрисовка плашки платёжки для админки
     */
    public static function drawAdminTile()
    {
    }

    /**
     * Получить дополнительную информацию о курсах всех поддерживаемых валют
     */
    public static function getUsdPriceArrayAll()
    {
        $payments = (new \Cake\Filesystem\Folder(ROOT . '/src/Lib/Payments'))->read()[1];
        $currencies = [];

        foreach ($payments as $token) {
            $class = '\\App\\Lib\\Payments\\' . str_replace('.php', '', $token);
            try {
                /**
                 * @var \App\Lib\Payments\CoinPayments $class
                 */
                if (!$class::DISABLED) {
                    $result = $class::getUsdPriceArray();
                    if(is_array($result)){
                        $currencies = array_merge($currencies, $result);
                    }
                }
            } catch (\Exception $e) {

            }
        }

        return $currencies;
    }


    /**
     * Курс поддерживаемых платежкой монет в долларах
     * @return array
     */
    public static function getUsdPriceArray()
    {
        return [];
    }


}