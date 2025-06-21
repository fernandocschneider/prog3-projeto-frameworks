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
        'completed' => 'permit_empty|in_list[t,f]',
        'deleted' => 'permit_empty|in_list[t,f]',
    ];

    protected $useSoftDeletes = false;

    public function findAll(?int $limit = null, int $offset = 0)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM tasks WHERE deleted = 'f' OR deleted IS NULL ORDER BY id DESC";
        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
            $result = $db->query($sql, [$limit, $offset])->getResultArray();
        } else {
            $result = $db->query($sql)->getResultArray();
        }
        
        return $result;
    }

    public function findById($id)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM tasks WHERE id = ? AND (deleted = 'f' OR deleted IS NULL)";
        $result = $db->query($sql, [$id])->getRowArray();
        
        return $result;
    }

    public function insert($data = null, bool $returnID = true)
    {
        $result = parent::insert($data, $returnID);
        return $result;
    }

    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);
        return $result;
    }
}
