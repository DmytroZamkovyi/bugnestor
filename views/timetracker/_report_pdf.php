<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>

<h2>Звіт по задачах</h2>

<?php if ($searchModel->totalTime): ?>
    <p><strong>Загальний час:</strong> <?= Yii::$app->formatter->asTime($searchModel->totalTime, 'H:mm') ?></p>
<?php endif; ?>

<?php if ($date_from || $date_to): ?>
    <p><strong>Період:</strong> <?= $date_from ?: '...' ?> - <?= $date_to ?: '...' ?></p>
<?php endif; ?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'date',
            'enableSorting' => false,
        ],
        [
            'attribute' => 'user.username',
            'label' => 'Користувач',
            'enableSorting' => false,
        ],
        [
            'attribute' => 'task.name',
            'enableSorting' => false,
        ],
        [
            'attribute' => 'time',
            'enableSorting' => false,
        ],
    ],
]) ?>