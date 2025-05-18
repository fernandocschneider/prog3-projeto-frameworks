<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f0fa;
            color: #5a3d78;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .btn {
            background-color: #a78bfa;
            color: white;
            border: none;
            padding: 1.5rem 3rem;
            font-size: 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(90, 61, 120, 0.3);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #7c3aed;
            transform: scale(1.05);
        }

        .creators {
            margin-top: 2rem;
            font-size: 1rem;
            color: #7e5f9e;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }
    </style>
</head>
<body>

    <a href="/tasks">
        <button class="btn">Ver Tarefas</button>
    </a>

    <div class="creators">
        Criado por: Jean Toral, João Ulisses, Fernando Schneider
    </div>

</body>
</html>
