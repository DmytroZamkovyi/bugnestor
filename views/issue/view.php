<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Issue $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пробелеми', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

/** @var \app\models\User $user */
$user = Yii::$app->user->identity;
?>
<div class="issue-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($user && ($user->isManager() || $user->isProgrammer())): ?>
        <p>
            <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Ви впевнені, що хочете видалити проблему? Це незворотна дія.',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'task_id',
                'format' => 'raw', // Дозволяє HTML
                'value' => function ($model) {
                    return $model->task
                        ? Html::a($model->task->name, ['task/view', 'id' => $model->task_id])
                        : 'Не вказано';
                },
            ],

            'name',
            'description:ntext',
            'enable:boolean',
            [
                'attribute' => 'create',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'update',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
        ],
    ]) ?>

</div>