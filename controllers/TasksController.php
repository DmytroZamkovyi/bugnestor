<?php

namespace app\controllers;
ini_set('memory_limit', '256M');
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Tasks;
use app\models\Task;
use app\models\Projects;


class TasksController extends Controller {
    public function actionIndex() {
        $taskModel = new Tasks();
        $projectModel = new Projects();

        $params = Yii::$app->request->queryParams;
        
        $projectId = isset($params['project_id']) ? $params['project_id'] : null;

        if (!$taskModel->load(['Tasks' => $params]) || !$taskModel->validate()) {
            Yii::$app->response->statusCode = 400;
            return $this->render('//site/error', [
                'name' => 'Invalid request parameters.',
                'message' => 'Invalid request parameters.',
                'exception' => new \yii\web\BadRequestHttpException('Invalid request parameters.'),
            ]);
        }


        $projects = $projectModel->get_all_short();  
        $tasks = $taskModel->get_all_short($projectId); 

        return $this->render('index', [
            'projects' => $projects,
            'tasks' => $tasks,
        ]);
    }

    public function actionFilter($project_id = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $taskModel = new Tasks();
        $taskModel->progect_id = $project_id;

        if ($project_id == 0) {
            $tasks = $taskModel->get_all_short2();
        } else {
            $tasks = $taskModel->get_all_short();
        }
    
        return $tasks;
    }

    public function actionView($id) {
        $model = new Task(['scenario' => 'view']);
        if (!$model->load(['Task' => Yii::$app->request->queryParams]) || !$model->validate()) {
            Yii::$app->response->statusCode = 400;
            return $this->render('//site/error', [
                'name' => 'Invalid request parameters.',
                'message' => 'Invalid request parameters.',
                'exception' => new \yii\web\BadRequestHttpException('Invalid request parameters.'),
            ]);
        }

        return $this->render('view', [
            'task' => $model->get($id),
        ]);
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $taskModel = new Task();
        $task = $taskModel->get_task_by_id($id);

        if (!$task) {
            return ['success' => false, 'message' => 'Задача не знайдена'];
        }

        // Отримання JSON з тіла запиту
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        if ($data) {
            $task->name = $data['name'] ?? $task->name;
            $task->status_id = $data['status_id'] ?? $task->status_id;
            $task->priority_id = $data['priority_id'] ?? $task->priority_id;
            $task->assigned_to_id = $data['assigned_to_id'] ?? $task->assigned_to_id;
            $task->description = $data['description'] ?? $task->description;

            if ($task->validate()) {
                if ($task->update()) {
                    return ['success' => true];
                } else {
                    return ['success' => false, 'message' => 'Помилка при збереженні змін'];
                }
            } else {
                return ['success' => false, 'message' => 'Некоректні валідаційні дані'];
            }
        }

        return ['success' => false, 'message' => 'Некоректні дані'];
    }

    public function actionCreate()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $taskModel = new Task(['scenario' => 'create']);
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        if ($data) {
            $taskModel->name = $data['title'] ?? 'не вказано';
            $taskModel->status_id = 1; // Статус за замовчуванням
            $taskModel->priority_id = $data['priority_id'] ?? 1; // Пріоритет за замовчуванням
            $taskModel->project_id = $data['project_id'] ?? 1; // Відповідальний за замовчуванням
            $taskModel->description = $data['description'] ?? 'не вказано';

            if ($taskModel->validate()) {
                if ($taskModel->save()) {

                    return ['success' => true];
                } else {
                    return ['success' => false, 'message' => 'Помилка при збереженні задачі'];
                }
            } else {
                return ['success' => false, 'message' => 'Некоректні валідаційні дані'];
            }
        }

        return ['success' => false, 'message' => 'Некоректні дані'];
    }

    public function actionCreateTrelloCard($name, $desc)
{
    $apiKey = 'bc42a440ba116e132defd3327fe9c261';
    $apiToken = '9a497f114f7eb749b130232863871d2207401de045312492c202a590e1452097';
    $listId = 'WFG6aatt'; // ID списку в Trello, куди додаємо картку

    $url = "https://api.trello.com/1/cards?key={$apiKey}&token={$apiToken}";


    $url = "https://api.trello.com/1/cards";
    $params = http_build_query([
        'key' => $apiKey,
        'token' => $apiToken,
        'idList' => $listId,
        'name' => $name,
        'desc' => $desc,
        'pos' => 'top',
    ]);
     $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status === 200 || $status === 201) {
        return $this->asJson([
            'success' => true,
            'message' => 'Задачу створено в Trello',
            'response' => json_decode($response, true),
        ]);
    } else {
        return $this->asJson([
            'success' => false,
            'message' => 'Помилка створення задачі',
            'response' => json_decode($response, true),
        ]);
    }
}

}