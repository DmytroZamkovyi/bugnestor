<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\ProjectUser $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="project-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(User::find()->orderBy('username')->all(), 'id', 'username'),
        ['prompt' => 'Оберіть користувача']
    ) ?>

    <?= $form->field($model, 'view_only')->checkbox() ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Скасувати', ['project/view', 'id' => $model->project_id], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>