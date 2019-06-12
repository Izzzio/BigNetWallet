<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 17.12.15
 * Time: 14:21
 */

namespace App\Lib;


use Cake\Log\Log;

class Email extends \Cake\Mailer\Email
{

    /**
     * Данные для тетирования
     *
     * @var array
     */
    private static $_testData = [];

    /**
     * Название скрипта в песочнице
     *
     * @var bool|string
     */
    private $sandboxScriptName = false;

    /**
     * Email constructor.
     *
     * @param array|string|null $config Array of configs, or string to load configs from email.php
     */
    function __construct($config = null)
    {
        parent::__construct($config);
        $this->addHeaders(['Precedence' => 'bulk']);
    }

    /**
     * Добавляет заголовки
     *
     * @param string $listId
     * @return $this
     */
    public function addListId($listId)
    {
        $this->addHeaders([
            'List-Id'              => $listId,
            'X-Postmaster-Msgtype' => $listId,
            'X-Mailru-Msgtype'     => $listId,
        ]);

        return $this;
    }

    public function setSandboxScript($name)
    {
        $this->sandboxScriptName = $name;

        return $this;
    }

    /**
     * Отправляет письмо обрабатывая исключения
     *
     *
     * @param null $content
     * @return bool|array
     */
    public function send($content = null)
    {

        if ($this->sandboxScriptName !== false) {

            $sandboxResult = Sandbox::runFromStorageOrIgnore($this->sandboxScriptName, $this->viewVars );
            if ($sandboxResult !== false) {
                return false;
            }
        }

        try {
            $result = parent::send($content);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $e->getMessage();
        }

        return $result;
        //}
    }

    /**
     * Передает массив с данными для тестирования
     *
     * @return array
     */
    public static function getTestData()
    {
        return self::$_testData;
    }

    /**
     * Очищает массив с данными для тестирования
     */
    public static function clearTestData()
    {
        self::$_testData = [];
    }

}
