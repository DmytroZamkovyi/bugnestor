<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Issue $model */

$this->title = 'Стрення проблеми';
$this->params['breadcrumbs'][] = ['label' => 'Проблеми', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
