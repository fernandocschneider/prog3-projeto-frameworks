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
        $this->taskModel->delete($id);
        return $this->response->setStatusCode(200);
    }

    public function add()
    {
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');

        $data = [
            'name' => $name,
            'description' => $description,
            'completed' => false
        ];

        $this->taskModel->insert($data);
        return $this->response->setStatusCode(200);
    }
    // Dentro da classe Tasks no arquivo app/Controllers/Tasks.php

    public function toggle($id)
    {
        // Pega o status enviado pelo JavaScript (true ou false)
        $data = $this->request->getJSON();
        $isCompleted = $data->completed;

        // Carrega o Model
        $model = new \App\Models\TaskModel();

        // Tenta atualizar o banco de dados
        $updated = $model->update($id, [
            'completed' => $isCompleted
        ]);

        // Verifica se a atualização foi bem-sucedida
        if ($updated) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error']);
        }
    }
}
