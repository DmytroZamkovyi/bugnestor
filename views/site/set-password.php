<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** 
 * @var yii\web\View $this 
 * @var app\models\SetPasswordForm $model 
 **/

$this->title = 'Встановлення паролю';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>Будь ласка, встановіть новий пароль для вашого облікового запису.</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_repeat')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
