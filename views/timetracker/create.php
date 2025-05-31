<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Timetracker $model */

$this->title = 'Create Timetracker';
$this->params['breadcrumbs'][] = ['label' => 'Timetrackers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timetracker-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
