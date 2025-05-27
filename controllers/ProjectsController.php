<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Projects;
use app\models\Project;

class ProjectsController extends Controller {
    public function actionIndex() {
        $model = new Projects();

        return $this->render('index', [
            'projects' => $model->get_all_short(),
        ]);
    }

    public function actionView() {
        $model = new Project(['scenario' => 'view']);
        if (!$model->load(['Project' => Yii::$app->request->queryParams]) || !$model->validate()) {
            Yii::$app->response->statusCode = 400;
            return $this->render('//site/error', [
                'name' => 'Invalid request parameters.',
                'message' => 'Invalid request parameters.',
                'exception' => new \yii\web\BadRequestHttpException('Invalid request parameters.'),
            ]);
        }

        return $this->render('view', [
            'project' => $model->get(),
        ]);
    }
}