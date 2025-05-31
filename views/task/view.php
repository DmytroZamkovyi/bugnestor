<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Task $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Завдання', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->identity && (Yii::$app->user->identity->isProgrammer() || Yii::$app->user->identity->isManager())): ?>
        <p>
            <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Ви впевнені, що хочете видалити завдання? Це незворотна дія.',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            [
                'attribute' => 'author_id',
                'value' => fn($model) => $model->author->username ?? '(невідомо)',
            ],
            [
                'attribute' => 'assigned_to_id',
                'value' => fn($model) => $model->assignedTo->username ?? '(немає)',
            ],
            [
                'attribute' => 'status_id',
                'value' => fn($model) => $model->status->name ?? '(немає)',
            ],
            [
                'attribute' => 'priority_id',
                'value' => fn($model) => $model->priority->name ?? '(немає)',
            ],
            [
                'attribute' => 'create',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'update',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ]
        ],
    ]) ?>

</div>