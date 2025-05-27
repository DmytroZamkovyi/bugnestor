<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Tasks;

class Project extends Model
{
    public $id;
    public $name;
    public $description;
    public $status;
    public $is_enable;
    public $code;
    public $tasks;
    
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'description'], 'string'],
            [['status'], 'string', 'max' => 255],
            [['is_enable'], 'boolean'],
            [['code'], 'string', 'max' => 32],
        ];
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['view'] = ['code'];
        return $scenarios;
    }

    public function get()
    {
        $sql = 'SELECT
            pr."id",
            pr."name",
            pr.description,
            s."name" status,
            s.is_enable,
            pr.code
        FROM
            project pr
            LEFT JOIN status s ON pr.status_id = s."id" 
            AND s.project_id = pr."id" 
            AND s.is_show
        WHERE
            pr.code = :code;';

        $project = Yii::$app->db->createCommand($sql)
            ->bindValue(':code', $this->code, \PDO::PARAM_STR)
            ->queryOne();

        if ($project) {
            $this->id = $project['id'];
            $this->name = $project['name'];
            $this->description = $project['description'];
            $this->status = $project['status'];
            $this->is_enable = $project['is_enable'];
            $this->code = $project['code'];
            
            $this->tasks = new Tasks(['scenario' => 'view', 'progect_id' => $this->id]);
        } else {
            throw new \Exception('Project not found');
        }

        return new Project([
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'is_enable' => $this->is_enable,
            'code' => $this->code,
            'tasks' => $this->tasks->get_all_short(),
        ]);
    }
}