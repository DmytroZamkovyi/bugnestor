<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Status extends Model
{
    public $id;
    public $name;
    public $description;
    public $is_enable;
    public $is_show;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'description'], 'string'],
            [['is_enable', 'is_show'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'is_enable' => 'Is Enable',
            'is_show' => 'Is Show',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['view'] = ['id'];
        return $scenarios;
    }
}