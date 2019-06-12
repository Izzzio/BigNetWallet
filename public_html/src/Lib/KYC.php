<?php

namespace App\Lib;

class KYC
{
    private static $_url;
    private static $_key;
    private static $_verifyAddress;
    private static $_usa;

    public function __construct()
    {
    }

    /**
     * Initialization
     * @param $config
     */
    public static function init($config)
    {
        self::$_url = $config['url'];
        self::$_key = $config['key'];
        self::$_verifyAddress = $config['verifyAddress'];
        self::$_usa = $config['usa'];
    }

    /**
     * POST request
     * @param string $url
     * @param array $headers
     * @param string $postParams
     * @return mixed
     * @throws \Exception
     */
    private static function requestPOST($url = '', $headers = [], $postParams = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        if ($postParams) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            throw new \Exception ('POST error: ' . curl_error($ch));
        }
        curl_close($ch);

        return $response;
    }

    /**
     * Get request
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    private static function requestGET($url = '', $headers = [], $params = [])
    {
        $params = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            throw new \Exception ('GET error: ' . curl_error($ch));
        }
        curl_close($ch);

        return $response;
    }

    /**
     * Create ApplicantID
     * @param bool $sourceKey
     * @param bool $externalUserId
     * @return array
     * @throws \Exception
     */
    public static function createApplicantId($sourceKey = false, $externalUserId = false)
    {
        $result = [
            'success' => false,
            'data'    => false,
        ];
        $url = self::$_url . '/resources/applicants?key=' . self::$_key;
        $params = [
            'sourceKey'      => $sourceKey,
            //'email' => '',
            'info'           => [
                'firstName' => '',
                'lastName'  => '',
            ],
            'requiredIdDocs' => [
                'docSets' => [
                    [
                        'idDocSetType' => 'IDENTITY',
                        'types'        => ['PASSPORT', 'DRIVERS', 'ID_CARD'], //PROOF_OF_PAYMENT:OTHER
                        'subTypes'     => ['FRONT_SIDE', 'BACK_SIDE'],
                    ],
                    [
                        'idDocSetType' => 'SELFIE',
                        'types'        => ['SELFIE'],
                        'subTypes'     => null,
                    ],
                ],
            ],
        ];
        if ($externalUserId) {
            $params['externalUserId'] = $externalUserId;
        }
        if (self::$_verifyAddress) {
            $params['requiredIdDocs']['docSets'][] =
                [
                    'idDocSetType' => 'PROOF_OF_RESIDENCE',
                    'types'        => ['UTILITY_BILL'],
                    'subTypes'     => null,
                ];
        }

        if (self::$_usa) {
            $params['requiredIdDocs']['docSets'][] =
                [
                    'idDocSetType' => 'PROOF_OF_PAYMENT',
                    'types'        => ['OTHER'],
                    'subTypes'     => null,
                ];
        }

        var_dump($params);
        die;

        $params = json_encode($params);

        $response = self::requestPOST($url, ['Content-Type:application/json', 'Accept: application/json'], $params);
        $responsePayload = json_decode($response, true);
        if (isset($responsePayload['code']) && isset($responsePayload['description'])) {
            $result['data'] = $responsePayload['description'];
        } elseif (isset($responsePayload['id'])) {
            $result['success'] = true;
            $result['data'] = $responsePayload['id'];
        }

        return $result;
    }

    /**
     * Generates Access token
     * @param string $userId
     * @return array
     * @throws \Exception
     */
    public static function createAccessToken($userId = '')
    {
        $result = [
            'success' => false,
            'data'    => false,
        ];
        $url = self::$_url . '/resources/accessTokens?userId=' . $userId . '&key=' . self::$_key;

        $response = self::requestPOST($url, ['Accept: application/json']);
        $responsePayload = json_decode($response, true);
        if (isset($responsePayload['code']) && isset($responsePayload['description'])) {
            $result['data'] = $responsePayload['description'];
        } elseif (isset($responsePayload['token'])) {
            $result['success'] = true;
            $result['data'] = $responsePayload['token'];
        }

        return $result;
    }

    /**
     * Generate userId
     * @param null $email
     * @param null $created
     * @return string
     */
    public static function createUserId($email = null, $created = null)
    {
        $partEmail = stristr($email, '@', true);
        if (false !== $partEmail) {
            $partEmail = strrev($partEmail);
        }

        $partCreated = str_replace('-', '', $created);
        $partCreated = str_replace(':', '', $partCreated);
        $partCreated = str_replace(' ', '', $partCreated);

        $result = $partEmail . $partCreated;

        return crypt($result, 'g4bnwL9gwe4grh');
    }

    /**
     * Change lang
     * @param null $abbr
     * @return string
     */
    public static function setLang($abbr = null)
    {
        switch ($abbr) {
            case 'en':
                $lang = 'en';
                break;
            case 'ru':
                $lang = 'ru';
                break;
            default:
                $lang = 'en';
        }

        return $lang;
    }

    /**
     * Get data
     * @param null $applicantId
     * @return mixed
     * @throws \Exception
     */
    public static function getVerifiedData($applicantId = null)
    {
        $url = self::$_url . '/resources/applicants/' . $applicantId;

        return self::requestGET($url, $headers = [], ['key' => self::$_key]);
    }
}