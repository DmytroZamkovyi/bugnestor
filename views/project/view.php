<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/** @var yii\web\View $this */
/** @var app\models\Project $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Проєкти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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

    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->isAdmin()): ?>
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
    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->isAdmin()): ?>
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

    <p>
        <?= Html::encode($model->description) ?>
    </p>


</div>