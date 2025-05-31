<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issue".
 *
 * @property int $id
 * @property int|null $task_id
 * @property string $name
 * @property string $description
 * @property int|null $enable
 * @property string|null $create
 * @property string|null $update
 */
class Issue extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'enable'], 'default', 'value' => null],
            [['task_id', 'enable'], 'default', 'value' => null],
            [['task_id', 'enable'], 'integer'],
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['create', 'update'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Завдання',
            'name' => 'Назва',
            'description' => 'Опис',
            'enable' => 'Активний',
            'create' => 'Створено',
            'update' => 'Оновлено',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

}
