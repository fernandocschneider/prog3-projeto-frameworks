<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = ['name', 'description', 'completed', 'deleted', 'created_at'];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'permit_empty',
        'completed' => 'permit_empty|boolean',
        'deleted' => 'permit_empty|in_list[0,1]',
    ];

    protected $useSoftDeletes = false;

    public function findAll(?int $limit = null, int $offset = 0)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM tasks WHERE deleted = false ORDER BY id DESC";
        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
            return $db->query($sql, [$limit, $offset])->getResultArray();
        }
        return $db->query($sql)->getResultArray();
    }
}
