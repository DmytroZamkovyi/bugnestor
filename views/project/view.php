<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/** @var yii\web\View $this */
/** @var app\models\Project $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Проєкти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

/** @var \app\models\User $user */
$user = Yii::$app->user->identity;
?>
<div class="project-view">
    <style>
        .micro-badge {
            font-size: 0.55rem;
            /* ще менше, ніж small */
            padding: 1px 4px;
            /* мінімальний внутрішній відступ */
            vertical-align: super;
            /* підняти вгору */
            margin-left: 4px;
            border-radius: 0.25rem;
            /* округлені кути */
            line-height: 1;
        }
    </style>
    <h1>
        <?= Html::encode($this->title) ?>
        <?php if ($model->private): ?>
            <sup><span class="badge bg-info micro-badge">Приватний</span></sup>
        <?php else: ?>
            <span class="badge bg-warning micro-badge">Публічний</span>
        <?php endif; ?>
        <?php if ($model->archive): ?>
            <sup><span class="badge bg-danger micro-badge">Архівний</span></sup>
        <?php endif; ?>
    </h1>

    <?php if ($user && $user->isAdmin()): ?>
        <p>
            <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Ви впевнені, що хочете видалити проєкт? Це незворотна дія.',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>
    <?php if ($user && $user->isAdmin()): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                // 'description:ntext',
                // 'private:boolean',
                // 'archive:boolean',
                'code',
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
    <?php endif; ?>

    <?php if ($user->isAdmin()): ?>
        <div class="card mt-4">
            <div class="card-header">
                <strong>Користувачі, які мають доступ</strong>
                <?= Html::a('Додати користувача', ['project-user/create', 'project_id' => $model->id], ['class' => 'btn btn-success btn-sm float-end']) ?>
            </div>
            <div class="card-body p-2">
                <ul class="list-group">
                    <?php foreach ($model->projectUsers as $projectUser): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= Html::encode($projectUser->user->username) ?>
                            <div>
                                <?php if ($projectUser->view_only): ?>
                                    <span class="badge bg-secondary">Глядач</span>
                                <?php endif; ?>
                                <?= Html::a('Видалити', ['project-user/delete', 'project_id' => $model->id, 'user_id' => $projectUser->user_id], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Ви впевнені, що хочете видалити користувача?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <p>
        <?= Html::encode($model->description) ?>
    </p>

</div>