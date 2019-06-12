<?php

namespace App\Lib;

use App\Model\Table\TransactionsTable;
use Cake\Core\Configure;

class Misc
{

    const COUNTRY = [
        'AF' => 'Afghanistan',
        'AX' => 'Åland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua & Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AC' => 'Ascension Island',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia & Herzegovina',
        'BW' => 'Botswana',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'VG' => 'British Virgin Islands',
        'BN' => 'Brunei',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'IC' => 'Canary Islands',
        'CV' => 'Cape Verde',
        'BQ' => 'Caribbean Netherlands',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'EA' => 'Ceuta & Melilla',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo - Brazzaville',
        'CD' => 'Congo - Kinshasa',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Côte d’Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CW' => 'Curaçao',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DG' => 'Diego Garcia',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong SAR China',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'XK' => 'Kosovo',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Laos',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macau SAR China',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar (Burma)',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'KP' => 'North Korea',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territories',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn Islands',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Réunion',
        'RO' => 'Romania',
        'RU' => 'Russia',
        'RW' => 'Rwanda',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'São Tomé & Príncipe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SX' => 'Sint Maarten',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia & South Sandwich Islands',
        'KR' => 'South Korea',
        'SS' => 'South Sudan',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'BL' => 'St. Barthélemy',
        'SH' => 'St. Helena',
        'KN' => 'St. Kitts & Nevis',
        'LC' => 'St. Lucia',
        'MF' => 'St. Martin',
        'PM' => 'St. Pierre & Miquelon',
        'VC' => 'St. Vincent & Grenadines',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard & Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syria',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad & Tobago',
        'TA' => 'Tristan da Cunha',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks & Caicos Islands',
        'TV' => 'Tuvalu',
        'UM' => 'U.S. Outlying Islands',
        'VI' => 'U.S. Virgin Islands',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VA' => 'Vatican City',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'WF' => 'Wallis & Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    ];

    /**
     * Yазвания месяцев для подписи документов
     */
    const MONTHS = [
        'небыбря',
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря',
    ];

    public static function mb_ucfirst($string, $enc = 'utf-8')
    {
        $string = mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) . mb_substr($string, 1, mb_strlen($string, $enc) - 1, $enc);

        return $string;
    }

    public static function mb_lcfirst($string, $enc = 'utf-8')
    {
        $string = mb_strtolower(mb_substr($string, 0, 1, $enc), $enc) . mb_substr($string, 1, mb_strlen($string, $enc) - 1, $enc);

        return $string;
    }

    public static function getCurrentDateString()
    {
        $day_arr = [
            '01' => 'первое',
            '02' => 'второе',
            '03' => 'третье',
            '04' => 'четвёртое',
            '05' => 'пятое',
            '06' => 'шестое',
            '07' => 'седьмое',
            '08' => 'восьмое',
            '09' => 'девятое',
            '10' => 'десятое',
            '11' => 'одинадцатое',
            '12' => 'двенадцатое',
            '13' => 'тринадцатое',
            '14' => 'четырнадцатое',
            '15' => 'пятнадцатое',
            '16' => 'шестнадцатое',
            '17' => 'семнадцатое',
            '18' => 'восемнадцатое',
            '19' => 'девятнадцатое',
            '20' => 'двадцатое',
            '21' => 'двадцать первое',
            '22' => 'двадцать второе',
            '23' => 'двадцать третье',
            '24' => 'двадцать четвёртое',
            '25' => 'двадцать пятое',
            '26' => 'двадцать шестое',
            '27' => 'двадцать седьмое',
            '28' => 'двадцать восьмое',
            '29' => 'двадцать девятое',
            '30' => 'тридцатое',
            '31' => 'тридцать первое',
        ];

        $month_arr = [
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря',
        ];


        $date_day_arr = [
            '1xx' => 'сто',
            '2xx' => 'двести',
            '3xx' => 'триста',
            '4xx' => 'четыреста',
            '5xx' => 'пятьсот',
            '6xx' => 'шестьсот',
            '7xx' => 'семьсот',
            '8xx' => 'восемьсот',
            '9xx' => 'девятьсот',
            '1'   => 'первого',
            '2'   => 'второго',
            '3'   => 'третьего',
            '4'   => 'четвёртого',
            '5'   => 'пятого',
            '6'   => 'шестого',
            '7'   => 'седьмого',
            '8'   => 'восьмого',
            '9'   => 'девятого',
            '10'  => 'десятого',
            '11'  => 'одинадцатого',
            '12'  => 'двенадцатого',
            '13'  => 'тринадцатого',
            '14'  => 'четырнадцатого',
            '15'  => 'пятнадцатого',
            '16'  => 'шестнадцатого',
            '17'  => 'семнадцатого',
            '18'  => 'восемнадцатого',
            '19'  => 'девятнадцатого',
            '20'  => 'двадцатого',
            '2X'  => 'двадцать',
            '30'  => 'тридцатого',
            '3X'  => 'тридцать',
            '40'  => 'сорокового',
            '4X'  => 'сорок',
            '50'  => 'пятидесятого',
            '5X'  => 'пятьдесят',
            '60'  => 'шестидесятого',
            '6X'  => 'шестьдесят',
            '70'  => 'семидесятого',
            '7X'  => 'семьдесят',
            '80'  => 'восьмидесятого',
            '8X'  => 'восемьдесят',
            '90'  => 'девяностого',
            '9X'  => 'девяносто',
        ];

        $day = date('d');
        $month = date('m');
        $year = date('Y');

        $str = $day_arr[$day] . ' ' . $month_arr[$month] . ' две тысячи';
        $ost = $year - 2000;
        $y2 = $ost % 100;
        $y1 = $ost - $y2;

        if (isset($date_day_arr[$y1])) {
            $str .= ' ' . $date_day_arr[$y1];
        }

        if (isset($date_day_arr[$y2])) {
            $str .= ' ' . $date_day_arr[$y2];
        } else {
            $y4 = $y2 % 10;
            $y3 = $y2 - $y4;
            $str .= ' ' . $date_day_arr[$y3 . 'X'];
            $str .= ' ' . $date_day_arr[$y4];
        }

        return $str . ' года';
    }

    /**
     * Приводит телефон к нормальному виду. Убирает все нецифры и заменяет 8 на 7 в начале. Или ставит 7, если её нет
     *
     * @param string $phone
     * @return string
     */
    public static function fixRussianPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if ((strlen($phone) == 11) && $phone[0] == '8') {
            $phone[0] = '7';
        } elseif (strlen($phone) == 10) {
            $phone = "7" . $phone;
        }

        return $phone;
    }

    /**
     * форматирует минуты в строчку
     *
     * @param int $minutes
     * @return string
     */
    public static function minutesToString($minutes)
    {
        $minutes = ceil($minutes);
        $hours = floor($minutes / 60);

        return (($hours > 0) ? $hours . ' ч ' : '') . ($minutes % 60) . ' мин';
    }


    /**
     * Returns project name
     * @return string
     */
    public static function projectName()
    {
        return Configure::read('App.appName');
    }

    /**
     * Returns token name
     * @return string
     */
    public static function tokenName()
    {
        return Configure::read('App.tokenName');
    }


    /**
     * Returns supportEmail
     * @return string
     */
    public static function supportEmail()
    {
        return Configure::read('App.supportEmail');
    }

    /**
     * Returns mainSite
     * @return string
     */
    public static function mainSite()
    {
        return Configure::read('App.mainSite');
    }

    /**
     * Returns policyUrl
     * @return string
     */
    public static function policyUrl()
    {
        return Configure::read('App.policyUrl');
    }

    /**
     * Returns whitepaperUrl
     * @return string
     */
    public static function whitepaperUrl()
    {
        return Configure::read('App.whitepaper');
    }


    /**
     * Returns enableDeposit
     * @return string
     */
    public static function depositEnabled()
    {
        return Configure::read('App.enableDeposit');
    }

    /**
     * Returns enableDeposit
     * @return string
     */
    public static function internalCurrency()
    {
        return Configure::read('App.internalCurrency');
    }

    /**
     * Retunrs enabledCurrenices
     * @return mixed
     */
    public static function enabledCurrencies()
    {
        return Configure::read('App.enabledCurrencies');
    }


    /**
     * Returns enableDeposit
     * @return string
     */
    public static function saleShowRatio()
    {
        return Configure::read('App.saleShowRatio');
    }

    /**
     * Return template config param
     * @param $param
     * @return mixed
     */
    public static function tcfg($param)
    {
        return Configure::read('App.Template.' . $param);
    }

    /**
     * Return link
     *
     * @param $param
     * @return mixed
     */
    public static function links($param)
    {
        return Configure::read('App.links.' . $param);
    }

    /**
     * @param $email
     * @param int $minLength
     * @param int $maxLength
     * @param string $mask
     * @return string
     */
    public static function maskEmail($email, $minLength = 3, $maxLength = 10, $mask = "***")
    {
        $atPos = strrpos($email, "@");
        $name = substr($email, 0, $atPos);
        $len = strlen($name);
        $domain = substr($email, $atPos);

        if (($len / 2) < $maxLength) {
            $maxLength = ($len / 2);
        }

        $shortenedEmail = (($len > $minLength) ? substr($name, 0, $maxLength) : "");

        return "{$shortenedEmail}{$mask}{$domain}";
    }


    /**
     *Создает код пользователя
     * @param int $userId
     * @return string
     */
    public static function makeUserCode($userId)
    {
        return Crypt::ecrypt($userId);
    }

    /**
     * Создаёт код восстановления с ограниченным временем жизни
     * @param int $userId
     * @param string $livetime
     * @return string
     */
    public static function makeRestoreCode($userId, $livetime = '+1 day')
    {
        return Crypt::ecrypt(json_encode(['id' => $userId, 't' => strtotime($livetime)]));
    }

    /**
     * Возвращает массив с id бользователя, и t - время жизни кода восстановления
     * @param string $code
     * @return array
     */
    public static function parseRestoreCode($code)
    {
        return json_decode(Crypt::dcrypt($code), true);
    }

    /**
     * Generates random password
     * @param int $length
     * @return string
     */
    public static function generatePassword($length = 5)
    {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }


    /**
     * Extract address from transaction
     * @param $rawdata
     * @return mixed|string
     */
    public static function extractPaymentAddr($rawdata)
    {
        if (!is_array($rawdata)) {
            $rawdata = json_decode($rawdata, true);
        }

        if (isset($rawdata['txData']['result']['address'])) {
            return $rawdata['txData']['result']['address'];
        }
        if (isset($rawdata['txData']['result']['result']['address'])) {
            return $rawdata['txData']['result']['result']['address'];
        }

        return '';

    }

    /**
     * Array 2 view 2d array
     * @param $arr
     * @return string
     */
    public static function array2View($arr)
    {
        $view = '';
        if (!is_array($arr)) {
            return '';
        }
        foreach ($arr as $key => $value) {
            $view .= $key . ': ' . $value . "\n";
        }

        return $view;
    }

    public static function userUploadPath($userId = null)
    {
        if (empty($userId)) {
            $userId = CurrentUser::get('id');
        }

        return WWW_ROOT . Configure::read('App.uploadsPath') . DS . $userId;
    }

    public static function userUploadWWW($userId = null)
    {
        return str_replace(WWW_ROOT, '', self::userUploadPath($userId));
    }


    /**
     * Get value per currencies
     * @return array
     */
    public static function getCurrenciesValue()
    {
        $currencies = [];
        foreach (\Cake\Core\Configure::read('App.enabledCurrencies') as $currency) {
            $currencies[$currency] = TransactionsTable::f()->select(['sum' => TransactionsTable::f()->func()->sum('amount')])->where(['currency' => $currency])->first()->sum;
            if (empty($currencies[$currency])) {
                $currencies[$currency] = 0;
            }
        }

        return $currencies;
    }

    /**
     * Get enabled currencies data
     * @return mixed
     */
    public static function getCurrenciesData()
    {
        return collection(CoinMarketCap::getAllCapitalization(true))->filter(function ($currency, $key) {
            return (isset($currency['symbol']) && in_array($currency['symbol'], self::enabledCurrencies()));
        })->toList();
    }

    /**
     * Get age based on date birthday
     * @param $bday string, YYYY-MM-DD
     * @return string
     */
    public static function calculateAge($bday = '')
    {
        $bday = new \DateTime($bday);
        $now = new \DateTime();
        $diff = $now->diff($bday);

        return $diff->y;
    }

    /*
     * Получает IP адрес, учитывая, что клиент может находится за cloudflare
     * @return string
     */
    public static function getIp()
    {
        return empty($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER['REMOTE_ADDR'] : $_SERVER["HTTP_CF_CONNECTING_IP"];
    }


    /**
     * Get currensies based on type
     * @param $type int, 0 = all, 1 - only enabled
     * @return []
     */
    public static function getCurrensiesList($type = 1)
    {
        $currensies = [];
        $currensiesNames = [];
        $allCurrensies = CoinMarketCap::SHORT_LONG;
        $allCurrensies['EUR'] = 'euro';
        $allCurrensies['USD'] = 'usd';
        $allCurrensies['RUB'] = 'rub';

        switch ($type){
            case 0:
                $currensiesNames = $allCurrensies;
                break;
            case 1:
                foreach(self::enabledCurrencies() as $key => $abbr){
                    if(isset($allCurrensies[$abbr])) {
                        $currensiesNames[$abbr] = $allCurrensies[$abbr];
                    }
                }
                break;
            default:
        }
        foreach($currensiesNames as $abbr => $name) {
            $currensies[] = [
                'abbr'  => $abbr,
                'name'  => $name,
            ];
        }
        return $currensies;
    }

    /**
     * Get all stages token sale
     * @return []
     */
    public static function getPeriodSales()
    {
        $periods = Configure::read('App.calculator');
        if ($periods) {
            if (isset($periods[1]['end'])) {
                $periods[1]['end_formatted'] = '1ws';
            }

        } else {
            $periods = [];
        }
        return $periods;
    }

    /**
     * Get user last login info
     * @param $userId
     * @return mixed
     */
    public static function getUserLastLogin($userId)
    {
        return KeyValue::read('last_login_' . $userId, false);
    }

    /**
     * Http POST request
     * @param $url
     * @param array $data
     * @return bool|mixed|string
     */
    public static function httpPost($url, $data = [])
    {
        if (str_replace(['http:/', 'https:/'], '', strtolower($url)) === strtolower($url)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $result = curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }

    public static function getUserRole()
    {
        $roleName = '';
        $userRole = CurrentUser::get('roles');
        if($userRole){
            $roleName = $userRole[0];
        }
        return $roleName;
    }

    /**
     * Account disabled holder
     */
    public static function accountDisabled()
    {

        if (strpos(json_encode($_REQUEST), 'getCrowdsaleData') !== false) {
            echo json_encode(["status" => "ok", "totalUSD" => rand(10000, 100000000)-rand(10000, 100000000)]);
        } else {
            ?>
            <html>
            <head>

                <title>iZ³ - IZZZIO Tokensale Platform</title>
                <link rel="shortcut icon" href="/images/favicon.ico">
                <style>
                    body {
                        background: #0f0f0f;
                        color: white;
                        text-align: center;
                        font-family: Arial;
                    }

                    a {
                        color: #f1ffff;
                        text-decoration: none;
                    }

                    a:hover {
                        text-decoration: underline;
                    }
                </style>
            </head>

            <body>
            <div style="padding-top: 35vh">
                <a href="https://izzz.io/en/cabinet/">
                    <img
                        style="max-height: 200px"
                        src="https://static.tildacdn.com/tild3761-3439-4666-a437-653763653136/logowhite.svg"></a>
                <h1>This account is temporarily disabled</h1>
                <h3>If you are the owner of this site, <a href="https://t.me/izzzio" target="_blank"> write to us in
                        support
                        chat</a></h3>
                <br><br>
                <p style="font-size: large; "><a href="https://izzz.io/en/cabinet/">
                        iZ³ Tokensale Platform</a></p>
            </div>

            <!-- Yandex.Metrika counter -->
            <script type="text/javascript">
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function () {
                        try {
                            w.yaCounter47787229 = new Ya.Metrika2({
                                id: 47787229,
                                clickmap: true,
                                trackLinks: true,
                                accurateTrackBounce: true,
                                webvisor: true
                            });
                        } catch (e) {
                        }
                    });

                    var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () {
                            n.parentNode.insertBefore(s, n);
                        };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = "https://mc.yandex.ru/metrika/tag.js";

                    if(w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else {
                        f();
                    }
                })(document, window, "yandex_metrika_callbacks2");
            </script>
            <noscript>
                <div><img src="https://mc.yandex.ru/watch/47787229" style="position:absolute; left:-9999px;" alt=""/>
                </div>
            </noscript>
            <!-- /Yandex.Metrika counter -->

            </body>
            </html>
            <?php
        }
        die;
    }


    /**
     * Валидация имейлов
     * @param $email
     * @return bool
     */
    public static function isValidEmail($email){
        if (strpos($email, '@') === false) {
            return false;
        }

        if (strpos($email, '.') === false) {
            return false;
        }
        if (strpos($email, ' ') !== false) {
            return false;
        }

        preg_match(Email::EMAIL_PATTERN, $email, $matches, PREG_OFFSET_CAPTURE);
        if (empty($matches)) {
            return false;
        }

        return true;
    }
}