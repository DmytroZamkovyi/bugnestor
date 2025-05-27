<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Task;

class Tasks extends Model
{
    public $progect_id;

    public function rules()
    {
        return [
            [['progect_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['view'] = ['progect_id'];
        $scenarios['filter'] = ['progect_id'];
        return $scenarios;
    }

    public function get_all_short()
    {
        $sql = 'SELECT
                    "id",
                    "name",
                    description,
                    status_id,
                    priority_id,
                    assigned_to_id,
                    updated_at 
                FROM
                    task 
                WHERE
                    project_id = :project_id';

        $tasks = Yii::$app->db->createCommand($sql)
            ->bindValue(':project_id', $this->progect_id, \PDO::PARAM_INT)
            ->queryAll();

        $tasks = array_map(function ($task) {
            switch ($task['status_id']) {
                case 1:
                    $task['status_id'] = 'New';
                    break;
                case 2:
                    $task['status_id'] = 'In Progress';
                    break;
                case 3:
                    $task['status_id'] = 'Completed';
                    break;
                default:
                    $task['status_id'] = 'Unknown';
            }
            switch ($task['priority_id']) {
                case 1:
                    $task['priority_id'] = 'Low';
                    break;
                case 2:
                    $task['priority_id'] = 'Medium';
                    break;
                case 3:
                    $task['priority_id'] = 'High';
                    break;
                default:
                    $task['priority_id'] = 'Unknown';
            }
            switch ($task['assigned_to_id']) {
                case 1:
                    $task['assigned_to_id'] = 'admin';
                    break;
                case 2:
                    $task['assigned_to_id'] = 'manager';
                    break;
                default:
                    $task['assigned_to_id'] = 'programmer';
            }
            return new Task([
                'id' => $task['id'],
                'name' => $task['name'],
                'description' => $task['description'],
                'status_id' => $task['status_id'],
                'priority_id' => $task['priority_id'],
                'assigned_to_id' => $task['assigned_to_id'],
                'updated_at' => $task['updated_at'],
            ]);
        }, $tasks);

        return $tasks;
    }

    public function get_all_short2()
    {
        $sql = 'SELECT
                    "id",
                    "name",
                    description,
                    status_id,
                    priority_id,
                    assigned_to_id,
                    updated_at 
                FROM
                    task';

        $tasks = Yii::$app->db->createCommand($sql)
            ->queryAll();

        $tasks = array_map(function ($task) {
            switch ($task['status_id']) {
                case 1:
                    $task['status_id'] = 'New';
                    break;
                case 2:
                    $task['status_id'] = 'In Progress';
                    break;
                case 3:
                    $task['status_id'] = 'Completed';
                    break;
                default:
                    $task['status_id'] = 'Unknown';
            }
            switch ($task['priority_id']) {
                case 1:
                    $task['priority_id'] = 'Low';
                    break;
                case 2:
                    $task['priority_id'] = 'Medium';
                    break;
                case 3:
                    $task['priority_id'] = 'High';
                    break;
                default:
                    $task['priority_id'] = 'Unknown';
            }
            switch ($task['assigned_to_id']) {
                case 1:
                    $task['assigned_to_id'] = 'admin';
                    break;
                case 2:
                    $task['assigned_to_id'] = 'manager';
                    break;
                default:
                    $task['assigned_to_id'] = 'programmer';
            }
            return new Task([
                'id' => $task['id'],
                'name' => $task['name'],
                'description' => $task['description'],
                'status_id' => $task['status_id'],
                'priority_id' => $task['priority_id'],
                'assigned_to_id' => $task['assigned_to_id'],
                'updated_at' => $task['updated_at'],
            ]);
        }, $tasks);

        return $tasks;
    }

}