<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Issue $model */

$this->title = 'Редагування проблеми: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Проблеми', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="issue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
