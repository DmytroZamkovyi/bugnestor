<?php

namespace app\models;

use yii\base\Model;

class SetPasswordForm extends Model
{
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password'], 'string', 'min' => 6],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'message' => 'Паролі не співпадають'],
        ];
    }

    public function generateSalt()
    {
        $ip = \Yii::$app->request->userIP;
        $time = microtime(true);
        $username = \Yii::$app->user->identity->username;
        return md5($ip . $time . $username);
    }
}
