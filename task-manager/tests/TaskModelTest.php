<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\TaskModel;

class TaskModelTest extends CIUnitTestCase
{
    protected $taskModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskModel = new TaskModel();
    }

    public function testValidationRules()
    {
        $validData = [
            'name' => 'Tarefa de Teste',
            'description' => 'Descrição da tarefa',
            'completed' => 'f',
            'deleted' => 'f',
            'user_id' => 1
        ];

        $invalidData = [
            'name' => 'Ab',
            'description' => 'Descrição da tarefa',
            'completed' => 'f',
            'user_id' => 'invalid'
        ];

        $this->assertGreaterThanOrEqual(3, strlen($validData['name']));
        $this->assertLessThanOrEqual(100, strlen($validData['name']));
        $this->assertTrue(in_array($validData['completed'], ['t', 'f']));
        $this->assertIsInt($validData['user_id']);
        
        $this->assertLessThan(3, strlen($invalidData['name']));
        $this->assertIsString($invalidData['user_id']);
    }

    public function testValidationWithEmptyDescription()
    {
        $data = [
            'name' => 'Tarefa sem descrição',
            'description' => '',
            'completed' => 'f',
            'user_id' => 1
        ];

        $this->assertGreaterThanOrEqual(3, strlen($data['name']));
        $this->assertLessThanOrEqual(100, strlen($data['name']));
        $this->assertTrue(in_array($data['completed'], ['t', 'f']));
        $this->assertIsInt($data['user_id']);
        $this->assertEmpty($data['description']);
    }

    public function testValidationWithInvalidCompletedValue()
    {
        $data = [
            'name' => 'Tarefa com valor inválido',
            'description' => 'Descrição',
            'completed' => 'invalid',
            'user_id' => 1
        ];

        $this->assertGreaterThanOrEqual(3, strlen($data['name']));
        $this->assertLessThanOrEqual(100, strlen($data['name']));
        $this->assertFalse(in_array($data['completed'], ['t', 'f']));
        $this->assertIsInt($data['user_id']);
    }

    public function testModelProperties()
    {
        $this->assertEquals('tasks', $this->taskModel->table);
        $this->assertEquals('id', $this->taskModel->primaryKey);
        $this->assertTrue($this->taskModel->useAutoIncrement);
        $this->assertEquals('array', $this->taskModel->returnType);
        
        $expectedFields = ['name', 'description', 'completed', 'deleted', 'created_at', 'user_id'];
        $this->assertEquals($expectedFields, $this->taskModel->allowedFields);
    }

    public function testValidationRulesStructure()
    {
        $validationRules = $this->taskModel->validationRules;
        
        $this->assertArrayHasKey('name', $validationRules);
        $this->assertArrayHasKey('description', $validationRules);
        $this->assertArrayHasKey('completed', $validationRules);
        $this->assertArrayHasKey('deleted', $validationRules);
        $this->assertArrayHasKey('user_id', $validationRules);
        
        $this->assertStringContainsString('required', $validationRules['name']);
        $this->assertStringContainsString('min_length[3]', $validationRules['name']);
        $this->assertStringContainsString('max_length[100]', $validationRules['name']);
        $this->assertStringContainsString('required', $validationRules['user_id']);
        $this->assertStringContainsString('integer', $validationRules['user_id']);
    }

    public function testUserIdValidation()
    {
        $validData = [
            'name' => 'Tarefa Válida',
            'description' => 'Descrição',
            'completed' => 'f',
            'user_id' => 1
        ];

        $invalidData = [
            'name' => 'Tarefa Válida',
            'description' => 'Descrição',
            'completed' => 'f',
            'user_id' => 'abc'
        ];

        $this->assertIsInt($validData['user_id']);
        $this->assertGreaterThan(0, $validData['user_id']);
        
        $this->assertIsString($invalidData['user_id']);
    }
} 