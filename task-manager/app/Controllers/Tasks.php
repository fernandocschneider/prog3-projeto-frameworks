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
            'tasks' => $this->taskModel->findAll()
        ];

        return view('tasks/index', $data);
    }
}