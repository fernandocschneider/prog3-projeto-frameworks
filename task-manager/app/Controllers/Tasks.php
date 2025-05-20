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
}
