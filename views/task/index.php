<?php

use app\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Завдання';
$this->params['breadcrumbs'][] = $this->title;

/** @var \app\models\User $user */
$user = Yii::$app->user->identity;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($user && ($user->isProgrammer() || $user->isManager())): ?>
        <p>
            <?= Html::a('Створити завдання', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'project_id',
                'value' => function ($model) {
                    return $model->project ? $model->project->name : '(немає)';
                },
            ],
            [
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return $model->author ? $model->author->username : '(немає)';
                },
            ],
            [
                'attribute' => 'assigned_to_id',
                'value' => function ($model) {
                    return $model->assignedTo ? $model->assignedTo->username : '(немає)';
                },
            ],
            [
                'attribute' => 'status_id',
                'value' => function ($model) {
                    return $model->status ? $model->status->name : '(немає)';
                },
            ],
            [
                'attribute' => 'priority_id',
                'value' => function ($model) {
                    return $model->priority ? $model->priority->name : '(немає)';
                },
            ],
            [
                'attribute' => 'update',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Task $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>

</div>