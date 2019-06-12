<?php

namespace App\Lib;


use App\Model\Entity\Task;
use App\Model\Table\TasksTable;

class Tasker
{


    const STANDART_LIMIT = 25;

    /**
     * Get tasks list by params
     * @param string $module
     * @param int $limit
     * @param mixed $status
     * @return array
     */
    public static function getModuleTasks($module, $limit = self::STANDART_LIMIT, $status = TasksTable::FLAG_NEW)
    {
        return TasksTable::f()->where(['type' => $module, 'flag' => $status])->limit($limit)->toArray();
    }

    /**
     * Get tasks by module and set it to pending
     * @param string $module
     * @param int $limit
     * @return Task[]
     */
    public static function getTasksInWork($module, $limit = self::STANDART_LIMIT)
    {
        /**
         * @var Task[] $tasks
         */
        $tasks = self::getModuleTasks($module, $limit);

        foreach ($tasks as &$task) {
            $task->flag = TasksTable::FLAG_PENDING;
            TasksTable::instance()->save($task);
        }

        // TasksTable::instance()->saveManyArr($tasksTemp);

        return $tasks;
    }

    /**
     * Set tasks finished
     * @param $tasks
     */
    public static function setTasksFinished($tasks)
    {
        foreach ($tasks as &$task) {
            $task->flag = TasksTable::FLAG_FINISHED;
            TasksTable::instance()->save($task);
        }
    }


    /**
     * Set tasks finished
     * @param $tasks
     */
    public static function setTasksNew($tasks)
    {
        foreach ($tasks as &$task) {
            $task->flag = TasksTable::FLAG_NEW;
            TasksTable::instance()->save($task);
        }
    }
    /**
     * Add new task
     * @param string $module
     * @param array $params
     * @return Task|bool
     */
    public static function addTask($module, $params = [])
    {
        $task = TasksTable::instance()->newEntity(
            [
                'type'   => $module,
                'flag'   => TasksTable::FLAG_NEW,
                'params' => $params,
            ]
        );

        if (!TasksTable::instance()->save($task)) {
            return false;
        }

        return $task;
    }

}