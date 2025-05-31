<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Task $model */

$this->title = 'Створити завдання';
$this->params['breadcrumbs'][] = ['label' => 'Завдання', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
