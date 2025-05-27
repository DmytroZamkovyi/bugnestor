<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Project;

class Projects extends Model
{
    public function get_all_short()
    {
        $sql = 'SELECT
            pr."id",
            pr."name",
            s."name" status,
            s.is_enable,
            pr.code
        FROM
            project pr
            LEFT JOIN status s ON pr.status_id = s."id" 
            AND s.project_id = pr."id" 
            AND s.is_show
        ORDER BY
            s.is_show DESC,
            pr."name";';

        $projects = Yii::$app->db->createCommand($sql)->queryAll();

        $projects = array_map(function ($project) {
            return new Project([
                'id' => $project['id'],
                'name' => $project['name'],
                'status' => $project['status'],
                'is_enable' => $project['is_enable'],
                'code' => $project['code'],
            ]);
        }, $projects);

        return $projects;
    }
    
}