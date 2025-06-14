<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TaskSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'project_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Project::find()->all(), 'id', 'name'),
        ['prompt' => 'Оберіть проєкт']
    ) ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'assigned_to_id') ?>

    <?= $form->field($model, 'status_id') ?>

    <?= $form->field($model, 'priority_id') ?>

    <?= $form->field($model, 'update') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
