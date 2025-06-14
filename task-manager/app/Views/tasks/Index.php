<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? 'Lista de Tarefas') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #6d28d9;
            --color-primary-light: #8b5cf6;
            --color-primary-dark: #5b21b6;
            --color-background: #f5f3ff;
            --color-surface: #ffffff;
            --color-text: #1f2937;
            --color-text-muted: #6b7280;
            --color-danger: #ef4444;
            --color-danger-dark: #dc2626;
            --color-border: #e5e7eb;
            --font-family: 'Poppins', sans-serif;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --border-radius: 0.75rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--color-background);
            color: var(--color-text);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            background-color: var(--color-surface);
            border-radius: var(--border-radius);
            padding: 2.5rem;
            width: 100%;
            max-width: 700px;
            box-shadow: var(--shadow-lg);
            animation: slideUp 0.5s ease-out;
        }

        h1 {
            text-align: center;
            font-size: 2.25rem;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 2rem;
            color: var(--color-primary-dark);
        }

        .task-header {
            display: grid;
            grid-template-columns: 30px 1fr 2fr 1fr 30px;
            font-weight: bold;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--color-text-muted);
            text-transform: uppercase;
            font-size: 0.75rem;
            border-bottom: 1px solid var(--color-border);
        }

        .task-item {
            display: grid;
            grid-template-columns: 30px 1fr 2fr 1fr 30px;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-bottom: 1px solid var(--color-border);
            transition: background-color 0.2s ease-in-out;
        }

        .task-item:last-child {
            border-bottom: none;
        }

        .task-item:hover {
            background-color: #f9fafb;
        }

        .task-name {
            font-weight: 600;
            font-size: 1rem;
            color: var(--color-text);
        }

        .task-description {
            font-size: 0.875rem;
            color: var(--color-text-muted);
        }

        .task-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: var(--color-primary);
            cursor: pointer;
            /* << PODE ADICIONAR ESTA LINHA */
        }

        /* Adicione este novo bloco ao final do seu CSS */
        .task-item--completed .task-name,
        .task-item--completed .task-description {
            text-decoration: line-through;
            color: var(--color-text-muted);
        }

        .task-item--completed {
            background-color: #f9fafb;
            opacity: 0.7;
        }

        .delete-btn {
            background-color: transparent;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0.8);
            transition: opacity 0.2s, transform 0.2s, background-color 0.2s;
        }

        .delete-btn svg {
            width: 20px;
            height: 20px;
            color: var(--color-danger);
        }

        .task-item:hover .delete-btn {
            opacity: 1;
            transform: scale(1);
        }

        .delete-btn:hover {
            background-color: #fee2e2;
        }

        .delete-btn:hover svg {
            color: var(--color-danger-dark);
        }

        .empty-message {
            text-align: center;
            color: var(--color-text-muted);
            padding: 3rem 1rem;
            background-color: #fafafa;
            border-radius: var(--border-radius);
            margin-top: 1rem;
        }

        .footer-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--color-border);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-family);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            border: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, background-color 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background-image: linear-gradient(to right, var(--color-primary-light), var(--color-primary));
            color: white;
        }

        .btn-primary:hover {
            background-image: linear-gradient(to right, #a881f5, #803de0);
        }

        .btn-secondary {
            background-color: var(--color-surface);
            color: var(--color-text-muted);
            border: 1px solid var(--color-border);
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        .btn-danger {
            background-color: var(--color-danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: var(--color-danger-dark);
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background-color: var(--color-surface);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            width: 100%;
            max-width: 500px;
            box-shadow: var(--shadow-lg);
            animation: slideUp 0.4s ease-out;
            text-align: center;
        }

        .modal-content h2 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: var(--color-text);
            font-size: 1.75rem;
        }

        .modal-content p {
            color: var(--color-text-muted);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .modal-content form {
            text-align: left;
        }

        .modal-content label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .modal-content input,
        .modal-content textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .modal-content input:focus,
        .modal-content textarea:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.2);
        }

        .modal-content .form-group {
            margin-bottom: 1.5rem;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .task-created {
            font-size: 0.75rem;
            color: var(--color-text-muted);
        }
    </style>
</head>

<body>

    <div class="container">
        <h1><?= esc($title ?? 'Lista de Tarefas') ?></h1>

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
                    <div class="task-item <?= $task['completed'] ? 'task-item--completed' : '' ?>">
                        <input type="checkbox" class="task-checkbox" data-id="<?= esc($task['id']) ?>" <?= $task['completed'] ? 'checked' : '' ?>>
                        <div class="task-name"><?= esc($task['name']) ?></div>
                        <div class="task-description"><?= esc($task['description']) ?></div>
                        <div class="task-created"><?= date('d/m/Y H:i', strtotime($task['created_at'])) ?></div>
                        <button class="delete-btn" data-id="<?= esc($task['id']) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.067-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
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
                    <textarea id="taskDescription" name="description" rows="3" placeholder="Ex: Ver tutoriais e praticar com um projeto" required></textarea>
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
    <script>
        let taskToDelete = null;

        function openModal() {
            document.getElementById("taskModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("taskModal").style.display = "none";
            document.getElementById("addTaskForm").reset();
        }

        function openDeleteModal() {
            document.getElementById("confirmDeleteModal").style.display = "flex";
        }

        function closeDeleteModal() {
            document.getElementById("confirmDeleteModal").style.display = "none";
            taskToDelete = null;
        }

        function attachDeleteListeners() {
            document.querySelectorAll('.delete-btn').forEach((btn) => {
                btn.addEventListener('click', function() {
                    taskToDelete = this.getAttribute('data-id');
                    openDeleteModal();
                });
            });
        }

        function confirmDelete() {
            if (!taskToDelete) return;

            fetch(`/tasks/delete/${taskToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return fetch('/tasks/list', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                    } else {
                        throw new Error('Erro ao excluir a tarefa');
                    }
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('task-list').innerHTML = html;
                    attachDeleteListeners();
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir a tarefa.');
                });

            closeDeleteModal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            attachDeleteListeners();

            document.getElementById('addTaskForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch('/tasks/add', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            return fetch('/tasks/list', {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });
                        } else {
                            throw new Error('Erro ao adicionar a tarefa');
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('task-list').innerHTML = html;
                        attachDeleteListeners();
                        closeModal();
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao adicionar a tarefa.');
                    });
                // Cole este novo bloco DENTRO do 'DOMContentLoaded'

                document.getElementById('task-list').addEventListener('change', function(e) {
                    if (e.target.matches('.task-checkbox')) {
                        const checkbox = e.target;
                        const taskId = checkbox.dataset.id;
                        const isCompleted = checkbox.checked;
                        const taskItem = checkbox.closest('.task-item');

                        // Feedback visual imediato
                        taskItem.classList.toggle('task-item--completed', isCompleted);

                        // Envia a atualização para o servidor
                        fetch(`/tasks/toggle/${taskId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    completed: isCompleted
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    // Se der erro, desfaz a alteração visual
                                    alert('Erro ao atualizar a tarefa.');
                                    taskItem.classList.toggle('task-item--completed', !isCompleted);
                                    checkbox.checked = !isCompleted;
                                }
                                // Não é preciso fazer nada em caso de sucesso, pois a UI já foi atualizada
                            })
                            .catch(error => {
                                console.error("Erro no fetch:", error);
                                alert('Erro ao conectar com o servidor.');
                                taskItem.classList.toggle('task-item--completed', !isCompleted);
                                checkbox.checked = !isCompleted;
                            });
                    }
                });
            });

            window.addEventListener("click", function(event) {
                const taskModal = document.getElementById("taskModal");
                const deleteModal = document.getElementById("confirmDeleteModal");
                if (event.target === taskModal) {
                    closeModal();
                }
                if (event.target === deleteModal) {
                    closeDeleteModal();
                }
            });
        });
    </script>
</body>

</html>