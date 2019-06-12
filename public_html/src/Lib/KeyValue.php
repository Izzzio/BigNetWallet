<?php

namespace App\Lib;


use App\Model\Table\KeyvalueTable;

class KeyValue
{

    const MAX_ALLOWED_CACHED_KEYS = 255;
    private static $_cache = [];


    /**
     * Write to key-value
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function read($key, $default = false)
    {
        if (!empty(self::$_cache[$key])) {
            return self::$_cache[$key];
        }
        /**
         * @var \App\Model\Entity\Keyvalue $result
         */
        $result = KeyvalueTable::f()->where(['key' => $key])->first();
        if (!empty($result)) {
            $value = json_decode($result->value, true);
            self::$_cache[$key] = $value;
            self::checkForClear();

            return $value;
        }

        return $default;
    }

    /**
     * Write to key-value
     * @param string $key
     * @param mixed $value
     * @return \App\Model\Entity\Keyvalue|bool
     */
    public static function write($key, $value)
    {
        $valueEncoded = json_encode($value);
        /**
         * @var \App\Model\Entity\Keyvalue $result
         */
        $result = KeyvalueTable::f()->where(['key' => $key])->first();
        if (!empty($result)) {
            $result->value = $valueEncoded;
        } else {
            $result = KeyvalueTable::instance()->newEntity(['key' => $key, 'value' => $valueEncoded]);
        }

        self::$_cache[$key] = $value;

        self::checkForClear();

        return KeyvalueTable::instance()->save($result);

    }

    /**
     * Delete key
     * @param string $key
     * @return bool|mixed
     */
    public static function delete($key)
    {
        self::$_cache[$key] = null;
        return KeyvalueTable::instance()->deleteAll(['key'=> $key]);
    }


    private static function checkForClear()
    {
        if (count(self::$_cache) > self::MAX_ALLOWED_CACHED_KEYS) {
            self::$_cache = [];
        }
    }
}