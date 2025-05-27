<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Issue extends Model
{
    public $id;
    public $task_id;
    public $task_name;
    public $title;
    public $description;
    public $status_id;
    public $status_name;
    public $priority_id;
    public $assignee_id;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['task_id', 'title', 'description', 'status_id'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['status_id', 'priority_id', 'assignee_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['status_name, task_name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'title' => 'Title',
            'description' => 'Description',
            'status_id' => 'Status ID',
            'priority_id' => 'Priority ID',
            'assignee_id' => 'Assignee ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['view'] = ['id'];
        return $scenarios;
    }

    public function get_issue_by_id($id)
    {
        $sql = '
        SELECT i.*, s.name as status_name, t.name as task_name, t.id as task_id
        FROM issue i
        LEFT JOIN status s ON i.status_id = s.id
        LEFT JOIN task t ON i.task_id = t.id
        WHERE i.id = :id;
        ';
        $issue = Yii::$app->db->createCommand($sql)
            ->bindValue(':id', $id)
            ->queryOne();

        return $issue ? new Issue($issue) : null;
    }

    public function save()
    {
        $this->status_id = 1; // Статус за замовчуванням, змініть, якщо потрібно

        $command = Yii::$app->db->createCommand()->insert('issue', [
            'title' => $this->title,
            'description' => $this->description,
            'status_id' => $this->status_id,
        ]);

        return $command->execute();
    }

    public function update()
    {
        $command = Yii::$app->db->createCommand()->update('issue', [
            'title' => $this->title,
            'description' => $this->description,
            'status_id' => $this->status_id,
        ], ['id' => $this->id]);

        return $command->execute();
    }

    public function updateAssign($taskId)
    {
        $this->task_id = $taskId;

        $command = Yii::$app->db->createCommand()->update('issue', [
            'task_id' => $this->task_id,
        ], ['id' => $this->id]);

        return $command->execute();
    }
}