<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Project;

/** @var yii\web\View $this */
/** @var app\models\TimetrackerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var integer|null $user_id */
/** @var integer|null $project_id */
/** @var string|null $date_from */
/** @var string|null $date_to */

$this->title = 'Звіт по обліку часу';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="timetracker-report-form">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['report'],
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($searchModel, 'user_id')->dropDownList(
                ArrayHelper::map(User::find()->all(), 'id', 'username'),
                ['prompt' => 'Всі користувачі', 'name' => 'user_id']
            ) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($searchModel, 'project_id')->dropDownList(
                ArrayHelper::map(Project::find()->all(), 'id', 'name'),
                ['prompt' => 'Всі проєкти', 'name' => 'project_id']
            ) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($searchModel, 'date_from')->input('date', ['name' => 'date_from']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($searchModel, 'date_to')->input('date', ['name' => 'date_to']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Фільтрувати', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Скинути', ['report'], ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a('Завантажити PDF', array_merge(['report-pdf'], Yii::$app->request->queryParams), ['class' => 'btn btn-danger', 'target' => '_blank']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php if ($searchModel->totalTime): ?>
    <div class="alert alert-success">
        Загальний час: <?= Yii::$app->formatter->asTime($searchModel->totalTime, 'H:mm') ?>
    </div>
<?php endif; ?>

<hr>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'user_id',
            'label' => 'Користувач',
            'value' => function ($model) {
                return $model->user->username ?? '(невідомо)';
            },
        ],
        [
            'attribute' => 'task_id',
            'label' => 'Задача',
            'value' => function ($model) {
                return $model->task->name ?? '(не вказано)';
            },
        ],
        [
            'label' => 'Проєкт',
            'value' => function ($model) {
                return $model->task->project->name ?? '(не вказано)';
            },
        ],
        'date',
        'time',
    ],
]); ?>