<?php if (!empty($tasks) && count($tasks) > 0): ?>
    <div class="task-header">
        <div></div>
        <div>Nome</div>
        <div>Descrição</div>
        <div></div>
    </div>
    <?php foreach ($tasks as $task): ?>
        <div class="task-item">
            <input type="checkbox" class="task-checkbox" <?= $task['completed'] ? 'checked' : '' ?> disabled>
            <div class="task-name"><?= esc($task['name']) ?></div>
            <div class="task-description"><?= esc($task['description']) ?></div>
            <button class="delete-btn" data-id="<?= esc($task['id']) ?>">✕</button>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="empty-message">Nenhuma tarefa encontrada.</div>
<?php endif; ?>