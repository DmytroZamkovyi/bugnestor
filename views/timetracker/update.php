<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Timetracker $model */

$this->title = 'Update Timetracker: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Timetrackers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="timetracker-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
