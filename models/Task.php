<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $author_id
 * @property int|null $assigned_to_id
 * @property int|null $status_id
 * @property int|null $priority_id
 * @property string $create
 * @property string $update
 *
 * @property User $assignedTo
 * @property User $author
 * @property Priority $priority
 * @property Status $status
 */
class Task extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'assigned_to_id', 'status_id', 'priority_id'], 'default', 'value' => null],
            [['id', 'name', 'author_id'], 'required'],
            [['id', 'author_id', 'assigned_to_id', 'status_id', 'priority_id'], 'default', 'value' => null],
            [['id', 'author_id', 'assigned_to_id', 'status_id', 'priority_id'], 'integer'],
            [['description'], 'string'],
            [['create', 'update'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['priority_id'], 'exist', 'skipOnError' => true, 'targetClass' => Priority::class, 'targetAttribute' => ['priority_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['assigned_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['assigned_to_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Назва',
            'description' => 'Опис',
            'author_id' => 'Автор',
            'assigned_to_id' => 'Призначено',
            'status_id' => 'Статус',
            'priority_id' => 'Пріоритет',
            'create' => 'Створено',
            'update' => 'Оновлено',
        ];
    }

    /**
     * Gets query for [[AssignedTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(User::class, ['id' => 'assigned_to_id']);
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Priority]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPriority()
    {
        return $this->hasOne(Priority::class, ['id' => 'priority_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

}
