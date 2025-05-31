<?php

namespace app\controllers;

use Yii;
use app\models\ProjectUser;

class ProjectUserController extends \yii\web\Controller
{
    public function actionCreate($project_id)
    {
        $model = new ProjectUser();
        $model->project_id = $project_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['project/view', 'id' => $project_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($project_id, $user_id)
    {
        ProjectUser::deleteAll(['project_id' => $project_id, 'user_id' => $user_id]);
        return $this->redirect(['project/view', 'id' => $project_id]);
    }
}
