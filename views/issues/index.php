<main id="main" class="flex-shrink-0" role="main">
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createIssueModal">
    Створити проблему
</button>

    <table class="table table-hover w-100">
        <thead>
            <tr>
                <th>ІД</th>
                <th>Назва</th>
                <th>Опис</th>
                <th>Статус</th>
                <th>Оновлено</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($issues as $issue) { ?>
                <tr class="clickable-row" data-code="<?= $issue->id ?>">
                    <td><?= $issue->id ?></td>
                    <td><?= $issue->title ?>
                </td>
                    <td><?= $issue->description ?></td>
                    <td><?= $issue->status_name ?></td>
                    <td><?= $issue->updated_at ?></td>
                </tr>
            <?php } ?>
                
        </tbody>
    </table>

<div class="modal fade" id="createIssueModal" tabindex="-1" aria-labelledby="createIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createIssueModalLabel">Створити проблему</h5>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                <!-- Кнопка, яка буде відправляти дані -->
                <button type="button" class="btn btn-primary" id="submit-button">Створити</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submit-button').addEventListener('click', function() {
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= \yii\helpers\Url::to(['issues/create']) ?>', true);
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
        description: description 
    }));
});
</script>

</main>

          
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
</script>
