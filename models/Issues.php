<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Issues extends Model
{
    public function get_all()
    {
        $sql = 'SELECT i.*, s.name as status_name
                FROM issue i
                LEFT JOIN status s ON i.status_id = s.id';
        $issues = Yii::$app->db->createCommand($sql)->queryAll();

        return array_map(function ($issue) {
            return new Issue($issue);
        }, $issues);
    }

    public function get_issues_by_project($projectId)
    {
        $sql = 'SELECT i.*, s.name as status_name
                FROM issue i
                LEFT JOIN status s ON i.status_id = s.id
                WHERE i.project_id = :project_id';
        $issues = Yii::$app->db->createCommand($sql)
            ->bindValue(':project_id', $projectId)
            ->queryAll();

        return array_map(function ($issue) {
            return new Issue($issue);
        }, $issues);
    }

    public function get_issues_by_status($statusId)
    {
        $sql = 'SELECT i.*, s.name as status_name
                FROM issue i
                LEFT JOIN status s ON i.status_id = s.id
                WHERE i.status_id = :status_id';
        $issues = Yii::$app->db->createCommand($sql)
            ->bindValue(':status_id', $statusId)
            ->queryAll();

        return array_map(function ($issue) {
            return new Issue($issue);
        }, $issues);
    }

    public function get_issues_by_assignee($assigneeId)
    {
        $sql = 'SELECT i.*, s.name as status_name
                FROM issue i
                LEFT JOIN status s ON i.status_id = s.id
                WHERE i.assignee_id = :assignee_id';
        $issues = Yii::$app->db->createCommand($sql)
            ->bindValue(':assignee_id', $assigneeId)
            ->queryAll();

        return array_map(function ($issue) {
            return new Issue($issue);
        }, $issues);
    }
}