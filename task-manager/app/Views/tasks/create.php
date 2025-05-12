<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Nova Task</title>
</head>
<body>
    <h1>Criar Nova Tarefa</h1>

    <?php if (session()->getFlashdata('message')) : ?>
        <p style="color: green;"><?= session()->getFlashdata('message') ?></p>
    <?php endif; ?>

    <form action="/tasks/store" method="post">
        <label for="name">Nome da Tarefa:</label><br>
        <input type="text" name="name" id="name" required><br><br>

        <label for="description">Descrição:</label><br>
        <textarea name="description" id="description"></textarea><br><br>

        <button type="submit">Criar Task</button>
    </form>
</body>
</html>
