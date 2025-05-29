<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Користувачі';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Додати користувача', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показано {begin}–{end} з {totalCount} записів',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'login',
            // 'password',
            // 'access_token',
            //'salt',
            'new:boolean',
            'admin:boolean',
            'manager:boolean',
            'programmer:boolean',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {set-password}',
                'buttons' => [
                    'set-password' => function ($url, $model, $key) {
                        return Html::a(
                            '<svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/></svg>',
                            ['user/set-password', 'id' => $model->id],
                            ['title' => 'Змінити пароль', 'data-method' => 'post', 'data-pjax' => '0']
                        );
                    },
                ],
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    if ($action === 'set-password') {
                        return Url::toRoute(['user/set-password', 'id' => $model->id]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],

        ],
    ]); ?>


</div>
