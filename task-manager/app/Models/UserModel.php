<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nome', 'email', 'senha'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nome' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'senha' => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O nome é obrigatório',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres',
            'max_length' => 'O nome deve ter no máximo 100 caracteres',
        ],
        'email' => [
            'required' => 'O email é obrigatório',
            'valid_email' => 'Digite um email válido',
            'is_unique' => 'Este email já está em uso',
        ],
        'senha' => [
            'required' => 'A senha é obrigatória',
            'min_length' => 'A senha deve ter pelo menos 6 caracteres',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function authenticate($email, $senha)
    {
        $user = $this->where('email', $email)->first();
        
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        
        return false;
    }

    public function createUser($data)
    {
        $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }
} 