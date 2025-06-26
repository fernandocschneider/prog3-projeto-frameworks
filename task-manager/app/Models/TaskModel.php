<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = ['name', 'description', 'completed', 'deleted', 'created_at', 'user_id'];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'permit_empty',
        'completed' => 'permit_empty|in_list[t,f]',
        'deleted' => 'permit_empty|in_list[t,f]',
        'user_id' => 'required|integer',
    ];

    protected $useSoftDeletes = false;

    public function findAll(?int $limit = null, int $offset = 0, $userId = null)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM tasks WHERE (deleted = 'f' OR deleted IS NULL)";
        
        $params = [];
        if ($userId !== null) {
            $sql .= " AND user_id = ?";
            $params[] = $userId;
        }
        
        $sql .= " ORDER BY id DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            $result = $db->query($sql, $params)->getResultArray();
        } else {
            $result = $db->query($sql, $params)->getResultArray();
        }
        
        return $result;
    }

    public function findById($id, $userId = null)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM tasks WHERE id = ? AND (deleted = 'f' OR deleted IS NULL)";
        $params = [$id];
        
        if ($userId !== null) {
            $sql .= " AND user_id = ?";
            $params[] = $userId;
        }
        
        $result = $db->query($sql, $params)->getRowArray();
        
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

    public function getTasksByUser($userId)
    {
        return $this->findAll(null, 0, $userId);
    }
}
