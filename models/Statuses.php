<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Statuses extends Model
{
    public function get_all()
    {
        $sql = 'SELECT * FROM status';
        $statuses = Yii::$app->db->createCommand($sql)->queryAll();

        return array_map(function ($status) {
            return new Status($status);
        }, $statuses);
    }
}