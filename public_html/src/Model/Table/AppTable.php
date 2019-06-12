<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 09.06.2016
 * Time: 13:10
 */

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class AppTable extends Table
{

    /**
     * Возвращает алиас таблицы, используемый тут повсюду
     *
     * @return string
     */
    public static function getAlias()
    {
        $classNameParts = explode('\\', static::class);
        return str_replace('Table', '', array_pop($classNameParts));
    }

    /**
     * Обёртка для TableRegistry::get() для автодополнения
     *
     * @return static
     */
    public static function instance()
    {
        return TableRegistry::get(static::getAlias());
    }

    /**
     * Альтернатива Table:instance->find()
     * @param string $type
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public static function f($type = 'all', $options = [])
    {
        return self::instance()->find($type, $options);
    }

    /**
     * Сохранение массивов, чтоб в одну строчку
     *
     * @param array $saveData
     * @param Entity|null|int $entity null для новой записи, сущность или её id для редактирования
     * @param array $options
     * @return bool|Entity
     */
    public function saveArr($saveData, $entity = null, $options = [])
    {
        if (empty($entity)) {
            $entity = $this->newEntity();
        } else {
            $entity = $this->getEntity($entity);
            if (empty($entity)) {
                return false;
            }
        }
        $entity = $this->patchEntity($entity, $saveData);
        return $this->save($entity, $options);
    }

    /**
     * Создаёт много сущностей из массива и сохраняет их
     *
     * @param array $saveData
     * @param array $options
     * @return array|bool|\Cake\ORM\ResultSet
     */
    public function saveManyArr($saveData, $options = [])
    {
        if (!is_array($saveData)) {
            return false;
        }
        return $this->saveMany($this->newEntities($saveData, $options));
    }

    /**
     * Если аргумент - сущность, то её и возвращает
     * Если число, то вытаскивает по нему сущность
     * Иначе - false
     *
     * @param Entity|int $entity
     * @param array $options
     * @return Entity|false
     */
    public function getEntity($entity, $options = [])
    {
        if ($entity instanceof Entity) {
            return $entity;
        }
        $entityId = (int)$entity;
        if (empty($entityId) || ($entityId < 1)) {
            return false;
        }
        return $this->get($entityId, $options);
    }


}