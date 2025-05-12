<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertTestTasks extends Migration
{
    public function up()
    {
        $data = [
            [
                'name'        => 'Planejar o sprint',
                'description' => 'Reunião de planejamento com o time.',
                'completed'   => false,
                'deleted'     => false,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Implementar autenticação',
                'description' => 'Adicionar login e autenticação de usuários.',
                'completed'   => false,
                'deleted'     => false,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Corrigir bugs da tela de tarefas',
                'description' => 'Corrigir os erros identificados durante os testes.',
                'completed'   => true,
                'deleted'     => false,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tasks')->insertBatch($data);
    }

    public function down()
    {
        $this->db->table('tasks')->whereIn('name', [
            'Planejar o sprint',
            'Implementar autenticação',
            'Corrigir bugs da tela de tarefas'
        ])->delete();
    }
}
