<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TaskModel;

class Tasks extends BaseController
{
    protected $taskModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Lista de Tarefas',
            'tasks' => $this->taskModel->findAll(),
        ];

        return view('tasks/index', $data);
    }
    public function list()
    {
        $tasks = $this->taskModel->findAll();
        return view('tasks/list', ['tasks' => $tasks]);
    }

    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        $sql = "UPDATE tasks SET deleted = true WHERE id = ?";
        $updated = $db->query($sql, [$id]);

        if ($updated) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Erro ao marcar tarefa como deletada']);
        }
    }

    public function add()
    {
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');

        $data = [
            'name' => $name,
            'description' => $description,
            'completed' => false,
            'created_at' => date('Y-m-d H:i:s')
        ];
        var_dump($data);

        $this->taskModel->insert($data);

        var_dump($this->taskModel->errors());
        return $this->response->setStatusCode(200);
    }
    // Dentro da classe Tasks no arquivo app/Controllers/Tasks.php

    public function toggle()
    {
        // Pega o status enviado pelo JavaScript (true ou false)
        $data = $this->request->getJSON();
        $isCompleted = (bool) $data->completed;
        $id = $data->id;

        // Carrega o Model
        $model = new \App\Models\TaskModel();
        $db = \Config\Database::connect();

        // Tenta atualizar o banco de dados com uma query SQL direta
        $sql = "UPDATE tasks SET completed = ? WHERE id = ?";
        $updated = $db->query($sql, [$isCompleted, $id]);

        // Verifica se a atualização foi bem-sucedida
        if ($updated) {
            return $this->response->setStatusCode(200)->setJSON(['status' => 'success']);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'completed' => $isCompleted,
                'message' => 'Erro ao atualizar a tarefa'
            ]);
        }
    }
}
