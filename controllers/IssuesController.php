<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Issues;
use app\models\Issue;
use app\models\Tasks;


class IssuesController extends Controller {
    public function actionIndex() {
        $issueModel = new Issues();
        $projectId = Yii::$app->request->get('project_id');

        if ($projectId) {
            $issues = $issueModel->get_issues_by_project($projectId);
        } else {
            $issues = $issueModel->get_all();
        }

        return $this->render('index', [
            'issues' => $issues,
        ]);
    }

    public function actionView($id) {
        $issueModel = new Issue();
        $taskModel = new Tasks();
        $issue = $issueModel->get_issue_by_id($id);
        $tasks = $taskModel->get_all_short2();

        if (!$issue) {
            throw new \yii\web\NotFoundHttpException('Issue not found.');
        }

        return $this->render('view', [
            'issue' => $issue,
            'tasks' => $tasks,
        ]);
    }

    public function actionCreate()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        
        $issue = new Issue();
        $issue->title = $data['title'] ?? '';
        $issue->description = $data['description'] ?? '';
        
        if ($issue->save()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Помилка при збереженні'];
        }
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        
        $issueModel = new Issue();
        $issue = $issueModel->get_issue_by_id($id);
        
        if (!$issue) {
            return ['success' => false, 'message' => 'Issue not found'];
        }
        
        $issue->title = $data['title'] ?? '';
        $issue->description = $data['description'] ?? '';
        
        if ($issue->update()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Помилка при збереженні'];
        }
    }

    public function actionAssign()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        
        $issueId = $data['issue_id'];
        $taskId = $data['task_id'];

        $issueModel = new Issue();
        $issue = $issueModel->get_issue_by_id($issueId);
    
        if (!$issue) {
            return ['success' => false, 'message' => 'Проблема не знайдена'];
        }
    
        if ($issue->updateAssign($taskId)) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Помилка при збереженні проблеми'];
        }
    }
}