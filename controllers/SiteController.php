<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Yii::$app->user->identity;

            if ($user->new) {
                return $this->redirect(['site/set-password']);
            }

            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionSetPassword()
    {
        $user = Yii::$app->user->identity;

        if (!$user->new) {
            return $this->goHome();
        }

        $model = new \app\models\SetPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->salt = $model->generateSalt();
            $user->password = hash('sha256', $user->salt . $model->password);
            $user->new = false;
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Пароль успішно змінено.');
                return $this->goHome();
            }
        }

        return $this->render('set-password', ['model' => $model]);
    }
}
