<?php

use yii\helpers\Html;

?>

<main id="main" role="main">
<h1><?= Html::encode($issue->title) ?></h1>
<?php if (!Yii::$app->user->isGuest) { ?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal">
            Редагувати проблему
        </button>
<?php } ?>
<p><strong>Опис: </strong></strong><?= Html::encode($issue->description) ?></p>
<p><strong>Статус: </strong><?= Html::encode($issue->status_name) ?></p>
<p><strong>Оновлено: </strong><?= Html::encode($issue->updated_at) ?></p>
<p>
        <strong>Задача: </strong>
        <span id="taskDisplay">
            <?= $issue->task_id 
                ? '<a href="/tasks/view?id=' . $issue->task_id . '">' . Html::encode($issue->task_name) . '</a>'
                : 'Задача не призначена' ?>
        </span>

<?php if (!Yii::$app->user->isGuest) { ?>
        <div class="d-flex align-items-center">
            <select id="taskSelect" class="form-select" aria-label="Виберіть задачу" style="width: 250px;">
                <option value="" selected hidden disabled>-- Виберіть задачу --</option>
                <?php foreach ($tasks as $task): ?>
                    <option value="<?= $task->id ?>"><?= Html::encode($task->name) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" id="assignButton" class="btn btn-primary ms-2">Призначити</button>
        </div>     
    </p>
<?php } ?>
</main>


<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Редагувати проблему</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        <div class="mb-3">
                            <label for="taskName" class="form-label">Назва проблеми</label>
                            <input type="text" class="form-control" id="taskName" name="name" value="<?= Html::encode($issue->title) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskStatus" class="form-label">Статус</label>
                            <select class="form-control" id="taskStatus" name="status_id">
                                <option value="1" <?= Html::encode($issue->status_id) == 1 ? 'selected' : '' ?>>Активний</option>
                                <option value="2" <?= Html::encode($issue->status_id) == 2 ? 'selected' : '' ?>>Архівний</option>
                                <option value="3" <?= Html::encode($issue->status_id) == 3 ? 'selected' : '' ?>>Новий </option>
                                <option value="3" <?= Html::encode($issue->status_id) == 4 ? 'selected' : '' ?>>Завершений </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Опис</label>
                            <textarea class="form-control" id="taskDescription" name="description" required><?= Html::encode($issue->description) ?></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button type="button" class="btn btn-primary" onclick="submitIssueForm()">Зберегти зміни</button>
                </div>
            </div>
        </div>
    </div>

<script>
    function submitIssueForm() {
    // Отримуємо значення з полів форми
    const taskName = document.getElementById('taskName').value;
    const taskStatus = document.getElementById('taskStatus').value;
    const taskDescription = document.getElementById('taskDescription').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // Створюємо об'єкт з даними форми
    const data = {
        title: taskName,
        status_id: taskStatus,
        description: taskDescription
    };

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/issues/update?id=<?= $issue->id ?>', true); // Вказати маршрут до вашого контролера
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

document.addEventListener('DOMContentLoaded', function() {
        const taskDisplay = document.getElementById('taskDisplay');
        const taskSelect = document.getElementById('taskSelect');
        const assignButton = document.getElementById('assignButton');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Обробник натискання на кнопку "Призначити"
        assignButton.addEventListener('click', function() {
            const selectedTaskId = taskSelect.value;
            if (selectedTaskId) {
                // Відправляємо AJAX запит для оновлення задачі
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/issues/assign', true); // Замінити на ваш актуальний роут контролера
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            location.reload(); // Перезавантажуємо сторінку для відображення змін
                        } else {
                            alert('Помилка при призначенні задачі.');
                        }
                    } else {
                        alert('Помилка сервера.');
                    }
                };
                xhr.send(JSON.stringify({ issue_id: <?= $issue->id ?>, task_id: selectedTaskId }));
            } else {
                alert('Будь ласка, виберіть задачу.');
            }
        });
    });
</script>