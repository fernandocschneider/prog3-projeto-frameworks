# Projeto de Frameworks

## Academicos

- Fernando Camilo Schneider
- Jean Carlo Toral
- João Ulisses Porto Alegre Ciriaco Teixeira

### Task List

Aplicação para gerenciamento de tarefas, permitindo ao usuário cadastrar, visualizar, editar, excluir e marcar tarefas como concluídas ou pendentes. Ideal para organizar compromissos e atividades diárias.

### Executando a aplicação

Primeiramente, é preciso criar um arquivo .env no root da aplicação.
O arquivo .env.example possui um modelo pronto com as configurações base.

Verifique se o Docker Desktop está instalado e rodando na sua máquina.
Execute o Docker Compose para criar os contêineres:

    docker-compose up -d

Entre no contêiner da aplicação para instalar as dependências:

    docker exec -it taskmanager-app bash
    composer install

Execute as migrações para criar as tabelas no banco de dados:

    docker exec -it taskmanager-app php spark migrate

Para visualizar a lista de tarefas, acesse:
http://localhost:8081/tasks

### Para conectar no banco de dados

Abra o DBeaver e crie uma nova conexão PostgreSQL
Configure os seguintes parâmetros:

    Host: localhost ou 127.0.0.1
    Port: 5434 (porta mapeada no docker-compose)
    Database: taskmanager
    Username: postgres
    Password: postgres
