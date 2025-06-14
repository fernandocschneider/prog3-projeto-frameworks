<?php if (!empty($tasks)): ?>
    <div class="task-header">
        <div></div>
        <div>Nome</div>
        <div>Descrição</div>
        <div>Criada em</div>
        <div></div>
    </div>
    <?php foreach ($tasks as $task): ?>
        <div class="task-item">
            <div class="task-checkbox">
                <input type="checkbox" <?= $task['completed'] ? 'checked' : '';?>>
            </div>
            <div class="task-name"><?= $task['name'];?></div>
            <div class="task-description"><?= $task['description'];?></div>
            <div class="task-created"><?= date('d/m/Y', strtotime($task['created_at']));?></div>
            <div class="task-actions">
                <a href="<?= base_url('tasks/delete/'. $task['id']);?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">Excluir</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="empty-message">Nenhuma tarefa encontrada. Adicione uma nova!</div>
<?php endif; ?>