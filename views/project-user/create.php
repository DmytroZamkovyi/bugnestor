<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProjectUser $model */

$this->title = 'Додати користувача до проєкту';
$this->params['breadcrumbs'][] = ['label' => 'Проєкти', 'url' => ['project/index']];
$this->params['breadcrumbs'][] = ['label' => 'Перегляд', 'url' => ['project/view', 'id' => $model->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-user-create">
    <h3><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>