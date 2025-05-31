<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Task $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'project_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Project::find()->all(), 'id', 'name'),
        ['prompt' => 'Оберіть проєкт']
    ) ?>

    <?= $form->field($model, 'assigned_to_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\User::find()->all(), 'id', 'username'),
        ['prompt' => 'Оберіть робітника']
    ) ?>

    <?= $form->field($model, 'status_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Status::find()->all(), 'id', 'name'),
        ['prompt' => 'Оберіть статус']
    )  ?>

    <?= $form->field($model, 'priority_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Priority::find()->all(), 'id', 'name'),
        ['prompt' => 'Оберіть пріоритет']
    )   ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>