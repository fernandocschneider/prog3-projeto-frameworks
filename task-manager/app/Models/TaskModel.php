<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    
    protected $allowedFields = ['name', 'description', 'completed', 'deleted'];
        
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'permit_empty',
        'completed' => 'permit_empty|in_list[0,1]',
        'deleted' => 'permit_empty|in_list[0,1]',
    ];
}