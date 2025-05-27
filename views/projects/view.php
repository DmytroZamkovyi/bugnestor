<?php

use yii\helpers\Html;
// use yii\helpers\Url;
// use yii\web\View;
// use app\models\Projects;
// use app\models\Project;
// use app\controllers\ProjectsController;

?>

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script> -->


<main id="main" role="main">
    <h1><?= Html::encode($project->name) ?></h1>
    <p><strong>Статус:</strong> <?= Html::encode($project->status) ?></p>
    <p><strong>Опис:</strong> <?= Html::encode($project->description) ?></p>

    <h3>Завдання</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="5%">ІД</th>
                <th width="20%">Назва</th>
                <th width="10%">Статус</th>
                <th width="10%">Пріоритет</th>
                <th width="20%">Призначено</th>
                <th width="10%">Оновлено</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($project->tasks as $task): ?>
                <tr class="clickable-row" data-code="<?= $task->id ?>">
                    <td><?= Html::encode($task->id) ?></td>
                    <td><?= Html::encode($task->name) ?></td>
                    <td><?= Html::encode($task->status_id) ?></td>
                    <td><?= Html::encode($task->priority_id) ?></td>
                    <td><?= Html::encode($task->assigned_to_id) ?></td>
                    <td><?= Html::encode($task->updated_at) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<script>
$(document).ready(function() {
    // $('.table').DataTable({
    //     "order": [], // за замовчуванням без сортування, або ["0", "asc"] для сорту по ID
    //     "paging": false, // якщо не хочеш пагінацію
    //     "info": false
    // });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.clickable-row').forEach(function (row) {
        row.addEventListener('click', function () {
            const code = this.dataset.code;
            if (code) {
                window.location.href = "<?= \yii\helpers\Url::to(['tasks/view', 'id' => '']) ?>" + code;
            }
        });
    });
});
</script>
