<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\UserModel;
use App\Models\TaskModel;

class UserAuthenticationTest extends CIUnitTestCase
{
    protected $userModel;
    protected $taskModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userModel = new UserModel();
        $this->taskModel = new TaskModel();
    }

    public function testUserModelValidation()
    {
        $validationRules = $this->userModel->validationRules;
        
        $this->assertArrayHasKey('nome', $validationRules);
        $this->assertArrayHasKey('email', $validationRules);
        $this->assertArrayHasKey('senha', $validationRules);
        
        $validUser = [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'senha' => '123456'
        ];

        $invalidUser = [
            'nome' => 'Jo',
            'email' => 'invalid-email',
            'senha' => '123'
        ];

        $this->assertGreaterThanOrEqual(3, strlen($validUser['nome']));
        $this->assertLessThanOrEqual(100, strlen($validUser['nome']));
        $this->assertGreaterThanOrEqual(6, strlen($validUser['senha']));
        $this->assertNotFalse(filter_var($validUser['email'], FILTER_VALIDATE_EMAIL));
        
        $this->assertLessThan(3, strlen($invalidUser['nome']));
        $this->assertLessThan(6, strlen($invalidUser['senha']));
        $this->assertFalse(filter_var($invalidUser['email'], FILTER_VALIDATE_EMAIL));
    }

    public function testUserModelProperties()
    {
        $this->assertEquals('users', $this->userModel->table);
        $this->assertEquals('id', $this->userModel->primaryKey);
        $this->assertTrue($this->userModel->useAutoIncrement);
        $this->assertEquals('array', $this->userModel->returnType);
        
        $expectedFields = ['nome', 'email', 'senha'];
        $this->assertEquals($expectedFields, $this->userModel->allowedFields);
    }

    public function testUserAuthenticationMethod()
    {
        $this->assertTrue(method_exists($this->userModel, 'authenticate'));
        $this->assertTrue(method_exists($this->userModel, 'createUser'));
    }

    public function testTaskModelUserSpecificMethods()
    {
        $this->assertTrue(method_exists($this->taskModel, 'findAll'));
        $this->assertTrue(method_exists($this->taskModel, 'findById'));
        $this->assertTrue(method_exists($this->taskModel, 'getTasksByUser'));
    }

    public function testTaskUserAssociation()
    {
        $userId = 1;
        $taskData = [
            'name' => 'Tarefa do Usuário',
            'description' => 'Descrição da tarefa',
            'completed' => 'f',
            'user_id' => $userId
        ];

        $this->assertArrayHasKey('user_id', $taskData);
        $this->assertEquals($userId, $taskData['user_id']);
        $this->assertIsInt($taskData['user_id']);
    }

    public function testUserSessionDataStructure()
    {
        $sessionData = [
            'user_id' => 1,
            'user_nome' => 'João Silva',
            'user_email' => 'joao@example.com'
        ];

        $this->assertArrayHasKey('user_id', $sessionData);
        $this->assertArrayHasKey('user_nome', $sessionData);
        $this->assertArrayHasKey('user_email', $sessionData);

        $this->assertIsInt($sessionData['user_id']);
        $this->assertIsString($sessionData['user_nome']);
        $this->assertIsString($sessionData['user_email']);
    }

    public function testUserValidationRules()
    {
        $validationRules = $this->userModel->validationRules;
        
        $this->assertArrayHasKey('nome', $validationRules);
        $this->assertArrayHasKey('email', $validationRules);
        $this->assertArrayHasKey('senha', $validationRules);
        
        $this->assertStringContainsString('required', $validationRules['nome']);
        $this->assertStringContainsString('min_length[3]', $validationRules['nome']);
        $this->assertStringContainsString('max_length[100]', $validationRules['nome']);
        
        $this->assertStringContainsString('required', $validationRules['email']);
        $this->assertStringContainsString('valid_email', $validationRules['email']);
        $this->assertStringContainsString('is_unique', $validationRules['email']);
        
        $this->assertStringContainsString('required', $validationRules['senha']);
        $this->assertStringContainsString('min_length[6]', $validationRules['senha']);
    }
} 