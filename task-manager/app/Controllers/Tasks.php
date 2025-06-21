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
        $sql = "UPDATE tasks SET deleted = 't' WHERE id = ?";
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

        $db = \Config\Database::connect();
        $sql = "INSERT INTO tasks (name, description, completed, created_at) VALUES (?, ?, 'f', ?)";
        $result = $db->query($sql, [$name, $description, date('Y-m-d H:i:s')]);

        if ($result) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Erro ao adicionar tarefa']);
        }
    }

    public function toggle()
    {
        $data = $this->request->getJSON();
        $isCompleted = (bool) $data->completed;
        $id = $data->id;

        $db = \Config\Database::connect();
        $completedValue = $isCompleted ? 't' : 'f';
        $sql = "UPDATE tasks SET completed = ? WHERE id = ?";
        $updated = $db->query($sql, [$completedValue, $id]);

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
