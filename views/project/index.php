<?php

use app\models\Project;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProjectSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Проєкти';
$this->params['breadcrumbs'][] = $this->title;

/** @var \app\models\User $user */
$user = Yii::$app->user->identity;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($user && $user->isAdmin()): ?>
        <p>
            <?= Html::a('Створити проєкт', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показано {begin}–{end} з {totalCount} записів',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = strip_tags($model->description);
                    if (mb_strlen($text) <= 80) {
                        return Html::encode($text);
                    }
                    $short = mb_substr($text, 0, 80);
                    $lastSpace = mb_strrpos($short, ' ');
                    $short = mb_substr($short, 0, $lastSpace);
                    return Html::encode($short) . '…';
                },
            ],
            'private:boolean',
            'archive:boolean',
            //'code',
            // 'create',
            [
                'attribute' => 'update',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Project $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) use ($user) {
                        return $user->isAdmin();
                    },
                    'delete' => function ($model, $key, $index) use ($user) {
                        return $user->isAdmin();
                    },
                ],
            ],

        ],
    ]); ?>


</div>
