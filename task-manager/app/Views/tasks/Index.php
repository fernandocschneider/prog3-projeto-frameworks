<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? 'Lista de Tarefas') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="/assets/css/style.css" as="style">
    <link rel="preload" href="/assets/js/app.js" as="script">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .user-details h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .user-details p {
            margin: 5px 0 0 0;
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .page-title {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($user['nome'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="user-details">
                    <h3><?= esc($user['nome'] ?? 'Usuário') ?></h3>
                    <p><?= esc($user['email'] ?? '') ?></p>
                </div>
            </div>
            <div>
                <h1 class="page-title"><?= esc($title ?? 'Lista de Tarefas') ?></h1>
            </div>
            <div>
                <a href="/auth/logout" class="logout-btn">Sair</a>
            </div>
        </div>

        <div id="task-list">
            <?php if (!empty($tasks)): ?>
                <div class="task-header">
                    <div></div>
                    <div>Nome</div>
                    <div>Descrição</div>
                    <div>Criada em</div>
                    <div></div>
                </div>
                <?php foreach ($tasks as $task): ?>
                    <div class="task-item <?= $task['completed'] == 't' ? 'task-item--completed' : '' ?>">
                        <input type="checkbox" class="task-checkbox" data-id="<?= esc($task['id']) ?>"
                            <?= $task['completed'] == 't' ? 'checked' : '' ?>>
                        <div class="task-name"><?= esc($task['name']) ?></div>
                        <div class="task-description"><?= esc($task['description']) ?></div>
                        <div class="task-created"><?= date('d/m/Y H:i', strtotime($task['created_at'])) ?></div>
                        <button class="delete-btn" data-id="<?= esc($task['id']) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.067-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-message">Nenhuma tarefa encontrada. Adicione uma nova!</div>
            <?php endif; ?>
        </div>

        <div class="footer-buttons">
            <a href="/" class="btn btn-secondary">Voltar para Início</a>
            <button class="btn btn-primary" onclick="openModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Adicionar Tarefa
            </button>
        </div>
    </div>

    <div id="taskModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2>Nova Tarefa</h2>
            <form id="addTaskForm">
                <div class="form-group">
                    <label for="taskName">Nome</label>
                    <input type="text" id="taskName" name="name" placeholder="Ex: Estudar PHP Avançado" required>
                </div>
                <div class="form-group">
                    <label for="taskDescription">Descrição</label>
                    <textarea id="taskDescription" name="description" rows="3"
                        placeholder="Ex: Ver tutoriais e praticar com um projeto" required></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Tarefa</button>
                </div>
            </form>
        </div>
    </div>

    <div id="confirmDeleteModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2>Confirmar Exclusão</h2>
            <p>Tem certeza que deseja excluir esta tarefa? Esta ação não pode ser desfeita.</p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
                <button class="btn btn-danger" onclick="confirmDelete()">Excluir</button>
            </div>
        </div>
    </div>

    <script src="/assets/js/app.js"></script>
</body>

</html>