<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Controller;

class TaskController extends Controller
{
    public function create()
    {
        return view('tasks/create');
    }

    public function store()
    {
        $taskModel = new TaskModel();

        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'completed'   => false,
            'deleted'     => false,
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $taskModel->insert($data);

        return redirect()->to('/tasks/create')->with('message', 'Task criada com sucesso!');
    }
}
