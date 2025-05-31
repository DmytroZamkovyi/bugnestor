<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $private
 * @property bool $archive
 * @property string $code
 * @property string $create
 * @property string $update
 *
 * @property ProjectUser[] $projectUsers
 * @property User[] $users
 */
class Project extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create',
                'updatedAtAttribute' => 'update',
                'value' => new Expression('NOW()'), // ← PostgreSQL сумісно
            ],
        ];
    }

    /**
     * @return string
     */
    public function beforeValidate()
    {
        if (empty($this->code)) {
            $this->code = md5($this->name . microtime(true));
        }

        return parent::beforeValidate();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['private'], 'default', 'value' => 1],
            [['archive'], 'default', 'value' => 0],
            [['name'], 'required'],
            [['description'], 'string'],
            [['private', 'archive'], 'boolean'],
            [['create', 'update'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 32],
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
            'private' => 'Приватний',
            'archive' => 'Архівний',
            'code' => 'Код',
            'create' => 'Створено',
            'update' => 'Оновлено',
        ];
    }

    /**
     * Gets query for [[ProjectUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['project_id' => 'id'])->with('user');
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('project_user', ['project_id' => 'id']);
    }


    /**
     * Returns a list of projects accessible to the given user.
     *
     * @param User $user The user for whom to retrieve accessible projects.
     * @return \yii\db\ActiveQuery The query object for the accessible projects.
     */
    public static function getAccessibleProjects($user)
    {
        if ($user->isAdmin()) {
            return self::find();
        }

        return self::find()
            ->joinWith('projectUsers')
            ->where(['project_user.user_id' => $user->id]);
    }
}
