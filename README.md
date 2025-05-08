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

bashdocker-compose up -d
Este comando irá:

Criar um contêiner para o PostgreSQL 17
Criar um contêiner para a aplicação PHP com Apache
Configurar a rede entre os contêineres

Entre no contêiner da aplicação para instalar as dependências:

bashdocker exec -it taskmanager-app bash
composer install

Execute as migrações para criar as tabelas no banco de dados:

bashphp spark migrate
Acessando a Aplicação
Após a configuração, a aplicação estará disponível em:
http://localhost:8080
Para visualizar a lista de tarefas, acesse:
http://localhost:8080/tasks
Conexão com o Banco de Dados (DBeaver)
Para conectar ao banco de dados usando o DBeaver:

Abra o DBeaver e crie uma nova conexão PostgreSQL
Configure os seguintes parâmetros:

Host: localhost
Port: 5433 (porta mapeada no docker-compose)
Database: taskmanager
Username: postgres
Password: postgres


-- Anotação (JEAN): docker exec -it taskmanager-app php spark serve
