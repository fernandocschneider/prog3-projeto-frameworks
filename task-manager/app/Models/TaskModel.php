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
        $cacheKey = "tasks_all_{$limit}_{$offset}";
        $cache = \Config\Services::cache();
        
        $cached = $cache->get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $db = \Config\Database::connect();
        $sql = "SELECT * FROM tasks WHERE deleted = false ORDER BY id DESC";
        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
            $result = $db->query($sql, [$limit, $offset])->getResultArray();
        } else {
            $result = $db->query($sql)->getResultArray();
        }

        $cache->save($cacheKey, $result, 300);
        
        return $result;
    }

    public function findById($id)
    {
        $cacheKey = "task_{$id}";
        $cache = \Config\Services::cache();
        
        $cached = $cache->get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $db = \Config\Database::connect();
        $sql = "SELECT * FROM tasks WHERE id = ? AND deleted = false";
        $result = $db->query($sql, [$id])->getRowArray();

        if ($result) {
            $cache->save($cacheKey, $result, 300);
        }
        
        return $result;
    }

    public function insert($data = null, bool $returnID = true)
    {
        $result = parent::insert($data, $returnID);
        
        $this->clearCache();
        
        return $result;
    }

    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);
        
        $this->clearCache();
        
        return $result;
    }

    private function clearCache()
    {
        $cache = \Config\Services::cache();
        $cache->delete('tasks_all');
        $cache->delete('tasks_all_');
        for ($i = 1; $i <= 100; $i++) {
            $cache->delete("task_{$i}");
        }
    }
}
