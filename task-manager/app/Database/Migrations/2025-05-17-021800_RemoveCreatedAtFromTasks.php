<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveCreatedAtFromTasks extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('tasks', 'created_at');
    }

    public function down()
    {
        $this->forge->addColumn('tasks', [
        'created_at' => [
            'type'       => 'DATETIME',
            'null'       => true,
            'default'    => null,
            'after'      => 'id', 
        ],
    ]);
    }
}
