<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_user".
 *
 * @property int $project_id
 * @property int $user_id
 * @property bool $view_only
 *
 * @property Project $project
 * @property User $user
 */
class ProjectUser extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['view_only'], 'default', 'value' => 0],
            [['project_id', 'user_id'], 'required'],
            [['project_id', 'user_id'], 'default', 'value' => null],
            [['project_id', 'user_id'], 'integer'],
            [['view_only'], 'boolean'],
            [['project_id', 'user_id'], 'unique', 'targetAttribute' => ['project_id', 'user_id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'view_only' => 'View Only',
        ];
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
