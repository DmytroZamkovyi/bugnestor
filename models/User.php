<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $login Логін
 * @property string|null $password Пароль
 * @property string|null $access_token
 * @property string|null $salt Сіль
 * @property bool|null $new Чи новий користувач
 * @property bool|null $admin Чи адмін
 * @property bool|null $manager Чи менеджер
 * @property bool|null $programmer Чи програміст
 * @method isAdmin()
 * @method isManager()
 * @method isProgrammer()
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'access_token', 'salt'], 'default', 'value' => null],
            [['new'], 'default', 'value' => 1],
            [['programmer'], 'default', 'value' => 0],
            [['username', 'login'], 'required'],
            [['new', 'admin', 'manager', 'programmer'], 'boolean'],
            [['username', 'login'], 'string', 'max' => 255],
            [['password', 'access_token'], 'string', 'max' => 64],
            [['salt'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Ім\'я',
            'login' => 'Логін',
            'password' => 'Пароль',
            'access_token' => 'Токен',
            'salt' => 'Сіль',
            'new' => 'Новий',
            'admin' => 'Адмін',
            'manager' => 'Менеджер',
            'programmer' => 'Розробник',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['login' => $username]); // login — це твій логін
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validatePassword($password)
    {
        return $this->password === hash('sha256', $this->salt . $password);
    }

    public function isAdmin()
    {
        return $this->admin === true;
    }

    public function isManager()
    {
        return $this->manager === true || $this->admin === true;
    }
    
    public function isProgrammer()
    {
        return $this->programmer === true || $this->admin === true;
    }
}
