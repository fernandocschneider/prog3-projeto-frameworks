# Projeto de Frameworks

## Academicos

- Fernando Camilo Schneider
- Jean Carlo Toral
- João Ulisses Porto Alegre Ciriaco Teixeira

## Projetos

### Task List

Aplicação para gerenciamento de tarefas, permitindo ao usuário cadastrar, visualizar, editar, excluir e marcar tarefas como concluídas ou pendentes. Ideal para organizar compromissos e atividades diárias.

### Controle de filmes assistidos

Sistema para registrar filmes assistidos pelo usuário, com informações como título, ano, gênero, nota e comentários. Permite edição, exclusão, filtro por critérios específicos e marcação de favoritos.

### Configuração Inicial
Clonando o Repositório
bashgit clone [URL-DO-REPOSITÓRIO]
cd [NOME-DA-PASTA]
Configurando o Ambiente

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

Abra o DBeaver e crie uma nova conexão PostgreSQL
Configure os seguintes parâmetros:

    Host: localhost ou 127.0.0.1
    Port: 5434 (porta mapeada no docker-compose)
    Database: taskmanager
    Username: postgres
    Password: postgres
