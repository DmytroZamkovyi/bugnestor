<?php

use app\models\Project;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProjectSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            //'create',
            //'update',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Project $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
