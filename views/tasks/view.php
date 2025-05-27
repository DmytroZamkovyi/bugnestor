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
    <h1><?= Html::encode($task->project_id)?>: <?= Html::encode($task->name) ?></h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal">
        Редагувати задачу
    </button>
    <p><strong>Статус:</strong> <?= Html::encode($task->status_id) ?></p>
    <p><strong>Пріоритет:</strong> <?= Html::encode($task->priority_id) ?></p>
    <p><strong>Призначено:</strong> <?= Html::encode($task->assigned_to_id) ?></p>
    <p><strong>Опис:</strong> <?= Html::encode($task->description) ?></p>

    <h3>Проблеми</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="5%">ІД</th>
                <th width="20%">Назва</th>
                <th width="10%">Статус</th>
                <th width="10%">Оновлено</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($task->issues as $issue): ?>
                <tr class="clickable-row" data-code="<?= $issue->id ?>">
                    <td><?= Html::encode($issue->id) ?></td>
                    <td><?= Html::encode($issue->title) ?></td>
                    <td><?= Html::encode($issue->status_id) ?></td>
                    <td><?= Html::encode($issue->updated_at) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Редагувати задачу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        <div class="mb-3">
                            <label for="taskName" class="form-label">Назва задачі</label>
                            <input type="text" class="form-control" id="taskName" name="name" value="<?= Html::encode($task->name) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskStatus" class="form-label">Статус</label>
                            <select class="form-control" id="taskStatus" name="status_id">
                                <option value="1" <?= Html::encode($task->status_id) == 'Новий' ? 'selected' : '' ?>>Новий</option>
                                <option value="2" <?= Html::encode($task->status_id) == 'В процесі' ? 'selected' : '' ?>>В процесі</option>
                                <option value="3" <?= Html::encode($task->status_id) == 'Зроблено' ? 'selected' : '' ?>>Зроблено</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="taskPriority" class="form-label">Пріоритет</label>
                            <select class="form-control" id="taskPriority" name="priority_id">
                                <option value="1" <?= Html::encode($task->priority_id) == 'Низький' ? 'selected' : '' ?>>Низький</option>
                                <option value="2" <?= Html::encode($task->priority_id) == 'Середній' ? 'selected' : '' ?>>Середній</option>
                                <option value="3" <?= Html::encode($task->priority_id) == 'Високий' ? 'selected' : '' ?>>Високий</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="taskAssignee" class="form-label">Відповідальна особа</label>
                            <select class="form-control" id="taskAssignee" name="assigned_to_id">
                                <option value="1" <?= Html::encode($task->assigned_to_id) == 'admin' ? 'selected' : '' ?>>admin</option>
                                <option value="2" <?= Html::encode($task->assigned_to_id) == 'manager' ? 'selected' : '' ?>>manager</option>
                                <option value="3" <?= Html::encode($task->assigned_to_id) == 'programmer' ? 'selected' : '' ?>>programmer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Опис</label>
                            <textarea class="form-control" id="taskDescription" name="description" required><?= Html::encode($task->description) ?></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button type="button" class="btn btn-primary" onclick="submitTaskForm()">Зберегти зміни</button>
                </div>
            </div>
        </div>
    </div>

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
                window.location.href = "<?= \yii\helpers\Url::to(['issues/view', 'id' => '']) ?>" + code;
            }
        });
    });
});

function submitTaskForm() {
    // Отримуємо значення з полів форми
    const taskName = document.getElementById('taskName').value;
    const taskStatus = document.getElementById('taskStatus').value;
    const taskPriority = document.getElementById('taskPriority').value;
    const taskAssignee = document.getElementById('taskAssignee').value;
    const taskDescription = document.getElementById('taskDescription').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // Створюємо об'єкт з даними форми
    const data = {
        name: taskName,
        status_id: taskStatus,
        priority_id: taskPriority,
        assigned_to_id: taskAssignee,
        description: taskDescription
    };

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/tasks/update?id=<?= $task->id ?>', true); // Вказати маршрут до вашого контролера
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.setRequestHeader('X-CSRF-Token', csrfToken);
    xhr.onload = function() {
        if (xhr.status === 200) {
            location.reload();
        } else {
            alert('Помилка сервера.');
        }
    };

    xhr.send(JSON.stringify(data));
}
</script>
