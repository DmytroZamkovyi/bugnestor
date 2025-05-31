<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "priority".
 *
 * @property int $id
 * @property string $name
 * @property int $order
 *
 * @property Task[] $tasks
 */
class Priority extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'priority';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'order'], 'required'],
            [['id', 'order'], 'default', 'value' => null],
            [['id', 'order'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'order' => 'Order',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['priority_id' => 'id']);
    }

}
