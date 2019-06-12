<?php
/*
 * iZ³ Crowdsale platform
 * Copyright (c) iZ³ | Izzz.io platform (izzz.io)
 * You can contact the copyright holder by e-mail info@izzz.io
 *
 * @copyright iZ³ | Izzz.io platform (izzz.io)
 * @link https://izzz.io
 * @author Andrey Nedobylsky (andrey@izzz.io)
 *
 */

namespace App\Controller;


use App\Controller\Component\IndianAuthComponent;
use App\Lib\Calculator;
use App\Lib\CBRF;
use App\Lib\CPA;
use App\Lib\CoinMarketCap;
use App\Lib\Crypt;
use App\Lib\CurrentUser;
use App\Lib\KeyValue;
use App\Lib\Misc;
use App\Lib\Payments\CoinPayments;
use App\Lib\Payments\Payment;
use App\Lib\Referal;
use App\Lib\Sandbox;
use App\Model\Table\KycAttemptsTable;
use App\Model\Table\TransactionsTable;
use App\Model\Table\UsersSettingsTable;
use App\Model\Table\UsersTable;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Event\Event;

use App\Lib\Email;
use Cake\Filesystem\Folder;
use Cake\I18n\I18n;
use Cake\I18n\Time;

use RuntimeException;


class ExternalApiController extends AppController
{


    /** @inheritdoc */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    /**
     * Dalong pay course
     * @param $currency
     * @return bool|string
     */
    public function dalongCourseApi($currency)
    {
        return self::dalongCourse($currency);
    }

    /**
     * Direct course
     * @param $currency
     * @return bool|mixed|string
     */
    public static function dalongCourse($currency)
    {
        $course = file_get_contents('https://buy.dalongpay.com/info/course/' . $currency);
        $course = json_decode($course, true);



        return $course;
    }
}

