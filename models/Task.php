<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Task extends Model
{

    public $id;
    public $project_id;
    public $name;
    public $description;
    public $status_id;
    public $status_name;
    public $priority_id;
    public $assigned_to_id;
    public $created_at;
    public $updated_at;
    public $issues;

    public function rules()
    {
        return [
            // [['id', 'project_id', 'status_id', 'priority_id', 'assigned_to_id'], 'integer'],
            // [['name', 'description'], 'string'],
            // [['created_at', 'updated_at'], 'safe'],
            // [['status_name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'name' => 'Name',
            'description' => 'Description',
            'status_id' => 'Status ID',
            'priority_id' => 'Priority ID',
            'assigned_to_id' => 'Assignee ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    } 

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['view'] = ['id'];
        $scenarios['create'] = ['project_id', 'name', 'description', 'status_id', 'priority_id'];
        return $scenarios;
    }

    public function get_task_by_id($id)
    {
        $sql = '
        SELECT t.*, s.name as status_name, p.name as project_name
        FROM task t
        LEFT JOIN status s ON t.status_id = s.id
        LEFT JOIN project p ON t.project_id = p.id
        WHERE t.id = :id;';

        $task = Yii::$app->db->createCommand($sql)
            ->bindValue(':id', $id, \PDO::PARAM_INT)
            ->queryOne();

        return new Task([
            'id' => $task['id'],
            'project_id' => $task['project_id'],
            'name' => $task['name'],
            'description' => $task['description'],
            'status_id' => $task['status_id'],
            'priority_id' => $task['priority_id'],
            'assigned_to_id' => $task['assigned_to_id'],
            'created_at' => $task['created_at'],
            'updated_at' => $task['updated_at'],
        ]);
    }

    public function get() 
    {
        $sql = 'SELECT
                    t.*, p.name project_id, t.name task_name
                FROM task t
                LEFT JOIN project p ON t.project_id = p.id
                WHERE t.id = :id;';

        $task = Yii::$app->db->createCommand($sql)
            ->bindValue(':id', $this->id, \PDO::PARAM_INT)
            ->queryOne();
        
        switch ($task['status_id']) {
            case 1:
                $task['status_id'] = 'Новий';
                break;
            case 2:
                $task['status_id'] = 'В процесі';
                break;
            case 3:
                $task['status_id'] = 'Зроблено';
                break;
            default:
                $task['status_id'] = 'Невизначено';
        }
        switch ($task['priority_id']) {
            case 1:
                $task['priority_id'] = 'Низький';
                break;
            case 2:
                $task['priority_id'] = 'Середній';
                break;
            case 3:
                $task['priority_id'] = 'Високий';
                break;
            default:
                $task['priority_id'] = 'Невизначено';
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
            'project_id' => $task['project_id'],
            'name' => $task['task_name'],
            'description' => $task['description'],
            'status_id' => $task['status_id'],
            'priority_id' => $task['priority_id'],
            'assigned_to_id' => $task['assigned_to_id'],
            'created_at' => $task['created_at'],
            'updated_at' => $task['updated_at'],
            'issues' => $this->get_issues($task['id']),
        ]);
    }

    public function get_issues($task_id) 
    {
        $sql = 'SELECT
                    *
                FROM issue i
                WHERE i.task_id = :task_id;';

        $issues = Yii::$app->db->createCommand($sql)
            ->bindValue(':task_id', $task_id, \PDO::PARAM_INT)
            ->queryAll();

        return array_map(function ($issue) {
            switch ($issue['status_id']) {
                case 1:
                    $issue['status_id'] = 'New';
                    break;
                case 2:
                    $issue['status_id'] = 'In Progress';
                    break;
                case 3:
                    $issue['status_id'] = 'Completed';
                    break;
                default:
                    $issue['status_id'] = 'Unknown';
            }
            return new Issue([
                'id' => $issue['id'],
                'title' => $issue['title'],
                'status_id' => $issue['status_id'],
                'updated_at' => $issue['updated_at'],
            ]);
        }, $issues);
    }

    public function save()
    {
        $command = Yii::$app->db->createCommand()->insert('task', [
            'project_id' => $this->project_id,
            'name' => $this->name,
            'description' => $this->description,
            'status_id' => $this->status_id,
            'priority_id' => $this->priority_id
        ]);

        return $command->execute();
    }

    public function update()
    {
        $sql = 'UPDATE task
                SET name = :name, description = :description, status_id = :status_id, priority_id = :priority_id, assigned_to_id = :assigned_to_id, updated_at = :updated_at
                WHERE id = :id';

        Yii::$app->db->createCommand($sql)
            ->bindValue(':name', $this->name)
            ->bindValue(':description', $this->description)
            ->bindValue(':status_id', $this->status_id)
            ->bindValue(':priority_id', $this->priority_id)
            ->bindValue(':assigned_to_id', $this->assigned_to_id)
            ->bindValue(':updated_at', $this->updated_at)
            ->bindValue(':id', $this->id)
            ->execute();
    }
}