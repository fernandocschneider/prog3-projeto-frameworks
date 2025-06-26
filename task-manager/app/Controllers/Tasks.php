<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TaskModel;
use App\Models\UserModel;

class Tasks extends BaseController
{
    protected $taskModel;
    protected $userModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $data = [
            'title' => 'Lista de Tarefas',
            'tasks' => $this->taskModel->getTasksByUser($userId),
            'user' => [
                'nome' => session()->get('user_nome'),
                'email' => session()->get('user_email')
            ]
        ];

        return view('tasks/index', $data);
    }

    public function list()
    {
        $userId = session()->get('user_id');
        $tasks = $this->taskModel->getTasksByUser($userId);
        return view('tasks/list', ['tasks' => $tasks]);
    }

    public function delete($id = null)
    {
        $userId = session()->get('user_id');
        $task = $this->taskModel->findById($id, $userId);
        if (!$task) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Tarefa não encontrada']);
        }

        $db = \Config\Database::connect();
        $sql = "UPDATE tasks SET deleted = 't' WHERE id = ? AND user_id = ?";
        $updated = $db->query($sql, [$id, $userId]);

        if ($updated) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Erro ao marcar tarefa como deletada']);
        }
    }

    public function add()
    {
        $userId = session()->get('user_id');
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');

        $db = \Config\Database::connect();
        $sql = "INSERT INTO tasks (name, description, completed, user_id, created_at) VALUES (?, ?, 'f', ?, ?)";
        $result = $db->query($sql, [$name, $description, $userId, date('Y-m-d H:i:s')]);

        if ($result) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Erro ao adicionar tarefa']);
        }
    }

    public function toggle()
    {
        $userId = session()->get('user_id');
        $data = $this->request->getJSON();
        $isCompleted = (bool) $data->completed;
        $id = $data->id;

        $task = $this->taskModel->findById($id, $userId);
        if (!$task) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Tarefa não encontrada']);
        }

        $db = \Config\Database::connect();
        $completedValue = $isCompleted ? 't' : 'f';
        $sql = "UPDATE tasks SET completed = ? WHERE id = ? AND user_id = ?";
        $updated = $db->query($sql, [$completedValue, $id, $userId]);

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
