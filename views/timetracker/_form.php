<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Timetracker $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="timetracker-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time')->input('time') ?>

    <?= $form->field($model, 'date')->input('date') ?>

    <?= $form->field($model, 'task_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>