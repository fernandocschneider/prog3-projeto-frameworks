<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f0fa;
            color: #5a3d78;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 4px 16px rgba(90, 61, 120, 0.15);
            display: flex;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .task-header {
            display: grid;
            grid-template-columns: 40px 1fr 1fr 40px;
            padding-bottom: 0.5rem;
            font-weight: bold;
            border-bottom: 2px solid #d3c1f3;
            text-align: left;
        }

        .task-header>div:nth-child(2),
        .task-header>div:nth-child(3) {
            background-color: #f9f5ff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 1.1rem;
            text-align: center;
            margin-right: 10px;
            border: 1px solid #e4d5f7;
        }

        .task-item {
            display: grid;
            grid-template-columns: 40px 1fr 1fr 40px;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee2ff;
            position: relative;
        }

        .delete-btn {
            width: 32px;
            height: 32px;
            background-color: #ff5a5a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.2s ease;
            font-size: 16px;
            position: absolute;
            right: 0;
        }

        .task-item:hover .delete-btn {
            opacity: 1;
        }

        .delete-btn:hover {
            background-color: #e73c3c;
            transform: scale(1.05);
        }

        .task-checkbox {
            width: 28px;
            height: 28px;
            accent-color: #a78bfa;
            margin: 0;
            display: flex;
            align-self: center;
            cursor: not-allowed;
        }

        .task-name {
            font-weight: bold;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .task-description {
            color: #7e5f9e;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .empty-message {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 2rem;
        }

        .footer-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            gap: 1rem;
        }

        .btn {
            background-color: #a78bfa;
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #7c3aed;
            transform: scale(1.05);
        }

        a {
            text-decoration: none;
        }

        /* Modal styles */
        .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: white;
        padding: 2.5rem 2rem;
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.25rem;
        font-family: "Segoe UI", sans-serif;
    }

    .modal-content h2 {
        margin-top: 0;
        color: #5a3d78;
        font-size: 1.6rem;
        text-align: center;
    }

    .modal-content label {
        align-self: flex-start;
        font-weight: 600;
        margin-bottom: -0.5rem;
        color: #5a3d78;
        font-size: 0.95rem;
    }

    .modal-content input,
    .modal-content textarea {
        width: 100%;
        padding: 0.9rem 1rem;
        border: 1px solid #d3c1f3;
        border-radius: 10px;
        font-size: 1rem;
        font-family: inherit;
        background-color: #f9f5ff;
        box-shadow: inset 0 1px 2px rgba(90, 61, 120, 0.05);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        resize: none; /* <- remove o redimensionamento */
        box-sizing: border-box;
    }

    .modal-content input:focus,
    .modal-content textarea:focus {
        border-color: #a78bfa;
        outline: none;
        box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.3);
        background-color: #fff;
    }

    .modal-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .modal-buttons .btn {
        padding: 0.75rem 1.8rem;
        font-size: 1rem;
        border-radius: 8px;
        font-weight: 500;
        min-width: 110px;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1><?= esc($title) ?></h1>

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
                    <button class="delete-btn" title="Excluir tarefa">✕</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-message">
                Nenhuma tarefa encontrada.
            </div>
        <?php endif; ?>

        <div class="footer-buttons">
            <button class="btn" onclick="openModal()">+ Adicionar Tarefa</button>
            <a href="/">
                <button class="btn">Voltar para Início</button>
            </a>
        </div>
    </div>

    <!-- Modal -->
    <div id="taskModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2>Nova Tarefa</h2>
            <label for="taskName">Nome</label>
            <input type="text" id="taskName" placeholder="Digite o nome da tarefa">

            <label for="taskDescription">Descrição</label>
            <textarea id="taskDescription" rows="4" placeholder="Digite a descrição"></textarea>

            <div class="modal-buttons">
                <button class="btn" onclick="closeModal()">Cancelar</button>
                <button class="btn">Salvar</button>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("taskModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("taskModal").style.display = "none";
        }

        // Fecha modal ao clicar fora do conteúdo
        window.addEventListener("click", function (event) {
            const modal = document.getElementById("taskModal");
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>

</body>

</html>
