<main id="main" class="flex-shrink-0" role="main">
    <div class="mb-3">
        <label for="projectSelect" class="form-label">Виберіть проект:</label>
        <select class="form-select" id="projectSelect">
            <option value="null" disable hidden selected>Оберіть проект</option>
            <!-- <option value="0">Всі проекти</option> -->
            <?php foreach ($projects as $project) { ?>
                <option value="<?= $project->id ?>"><?= $project->name ?></option>
            <?php } ?>
        </select>
    </div>
<?php if (!Yii::$app->user->isGuest) { ?>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createIssueModal">
        Створити задачу
    </button>
<?php } ?>
    <div class="modal fade" id="createIssueModal" tabindex="-1" aria-labelledby="createIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createIssueModalLabel">Створити задачу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Назва</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Опис</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="taskPriority" class="form-label">Пріоритет</label>
                    <select class="form-control" id="taskPriority" name="priority_id">
                        <option value="1">Низький</option>
                        <option value="2">Середній</option>
                        <option value="3">Високий</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="projectSelectMod" class="form-label">Виберіть проект:</label>
                    <select class="form-select" id="projectSelectMod">
                        <option value="null" disable hidden selected>Оберіть проект</option>
                        <?php foreach ($projects as $project) { ?>
                            <option value="<?= $project->id ?>"><?= $project->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                <!-- Кнопка, яка буде відправляти дані -->
                <button type="button" class="btn btn-primary" id="submit-button">Створити</button>
            </div>
        </div>
    </div>
</div>

    <table class="table table-hover w-100" id="tasksTable">
        <thead>
            <tr>
                <th>ІД</th>
                <th>Назва</th>
                <th>Статус</th>
                <th>Пріоритет</th>
                <th>Призначено</th>
                <th>Оновлено</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</main>

<script>
document.getElementById('projectSelect').addEventListener('change', function() {
    var selectedProjectId = this.value;

    // Відправка AJAX-запиту
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/tasks/filter?project_id=' + selectedProjectId, true); // Змінюємо шлях на ваш маршрут контролера
    xhr.onload = function() {
        if (xhr.status === 200) {
            var tasks = JSON.parse(xhr.responseText);
            var tbody = document.querySelector('#tasksTable tbody');
            tbody.innerHTML = ''; // Очищаємо таблицю

            tasks.forEach(function(task) {
                let priorityText;
                let statusText;

                switch (task.status_id) {
                    case 'New':
                        statusText = 'Новий';
                        break;
                    case 'In Progress':
                        statusText = 'В процесі';
                        break;
                    case 'Completed':
                        statusText = 'Зроблено';
                        break;
                    default:
                    statusText = 'Невизначено'; // значення за замовчуванням, якщо ID не відповідає жодному з відомих варіантів
                }

                switch (task.priority_id) {
                    case 'Low':
                        priorityText = 'Низький';
                        break;
                    case 'Medium':
                        priorityText = 'Середній';
                        break;
                    case 'High':
                        priorityText = 'Високий';
                        break;
                    default:
                        priorityText = 'Невизначено'; // значення за замовчуванням, якщо ID не відповідає жодному з відомих варіантів
                }
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${task.id}</td>
                    <td>${task.name}</td>
                    <td>${statusText}</td>
                    <td>${priorityText}</td>
                    <td>${task.assigned_to_id}</td>
                    <td>${task.updated_at}</td>
                `;
                row.classList.add('clickable-row');
                row.setAttribute('data-code', task.id);
                tbody.appendChild(row);
            });

    document.querySelectorAll('.clickable-row').forEach(function (row) {
        row.addEventListener('click', function () {
            const code = this.dataset.code;
            if (code) {
                window.location.href = "<?= \yii\helpers\Url::to(['tasks/view', 'id' => '']) ?>" + code;
            }
    });
});
        }
    };
    xhr.send(JSON.stringify({ project_id: selectedProjectId }));
});
</script>

<script>
    document.getElementById('submit-button').addEventListener('click', function() {
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;
        const priority = document.getElementById('taskPriority').value;
        const projectId = document.getElementById('projectSelectMod').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= \yii\helpers\Url::to(['tasks/create']) ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-Token', csrfToken);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Успішно створено issue - оновлюємо інтерфейс або закриваємо модальне вікно
                        location.reload(); // наприклад, оновлюємо сторінку
                    } else {
                        // Відображаємо повідомлення про помилку
                        alert('Помилка при створенні проблеми: ' + response.message);
                    }
                } else {
                    // Обробляємо помилку
                    alert('Запит не вдався. Спробуйте пізніше.');
                }
            }
        };

        xhr.send(JSON.stringify({ 
            title: title, 
            description: description,
            priority_id: priority,
            project_id: projectId 
        }));
    });
</script>
