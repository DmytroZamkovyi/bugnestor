<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Зміна пароля для: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Користувачі', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-set-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <label for="password">Новий пароль</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Зберегти пароль', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>