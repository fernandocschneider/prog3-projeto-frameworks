<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo - Task Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .welcome-container {
            text-align: center;
            max-width: 600px;
            padding: 40px;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .welcome-subtitle {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .buttons-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .btn {
            padding: 1.2rem 2.5rem;
            font-size: 1.1rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 50px;
            text-align: left;
        }

        .feature {
            background: rgba(255, 255, 255, 0.1);
            padding: 25px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature h3 {
            margin: 0 0 15px 0;
            font-size: 1.2rem;
            color: #fff;
        }

        .feature p {
            margin: 0;
            opacity: 0.8;
            line-height: 1.5;
        }

        .creators {
            margin-top: 3rem;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
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

        @media (max-width: 768px) {
            .welcome-title {
                font-size: 2.5rem;
            }
            
            .welcome-subtitle {
                font-size: 1.1rem;
            }
            
            .buttons-container {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 250px;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="welcome-container">
        <h1 class="welcome-title">Task Manager</h1>
        <p class="welcome-subtitle">
            Organize suas tarefas de forma simples e eficiente. 
            Gerencie seus projetos com facilidade e mantenha o controle total sobre suas atividades.
        </p>

        <div class="buttons-container">
            <a href="/auth" class="btn btn-primary">Fazer Login</a>
            <a href="/auth/register" class="btn btn-secondary">Criar Conta</a>
        </div>

        <div class="features">
            <div class="feature">
                <h3>📝 Organização Simples</h3>
                <p>Crie, edite e organize suas tarefas de forma intuitiva e rápida.</p>
            </div>
            <div class="feature">
                <h3>✅ Controle Total</h3>
                <p>Marque tarefas como concluídas e acompanhe seu progresso em tempo real.</p>
            </div>
            <div class="feature">
                <h3>🔒 Segurança</h3>
                <p>Seus dados estão protegidos com autenticação segura e criptografia.</p>
            </div>
            <div class="feature">
                <h3>🌐 Acesso em Qualquer Lugar</h3>
                <p>Gerencie suas tarefas de qualquer dispositivo, a qualquer hora, com total praticidade.</p>
            </div>
        </div>
    </div>

    <div class="creators">
        Criado por: Jean Toral, João Ulisses, Fernando Schneider
    </div>

</body>
</html>
