<?php

// use yii\helpers\Html;
use yii\helpers\Url;
// use yii\web\View;
// use app\models\Projects;
// use app\models\Project;
// use app\controllers\ProjectsController;

?>

<main id="main" role="main">
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="10%">ІД</th>
                <th>Назва</th>
                <th width="20%">Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr class="clickable-row <?= $project->is_enable ? '' : 'table-danger' ?>" data-code="<?= $project->code ?>">
                    <td><?= $project->id ?></td>
                    <td><?= $project->name ?></td>
                    <td><?= $project->status ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.clickable-row').forEach(function (row) {
        row.addEventListener('click', function () {
            const code = this.dataset.code;
            if (code) {
                window.location.href = "<?= \yii\helpers\Url::to(['projects/view', 'code' => '']) ?>" + code;
            }
        });
    });
});
</script>
