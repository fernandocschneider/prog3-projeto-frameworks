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
            'deleted' => 'f'
        ];

        $this->assertTrue($this->taskModel->validate($validData));

        $invalidData = [
            'name' => 'Ab',
            'description' => 'Descrição da tarefa',
            'completed' => 'f'
        ];

        $this->assertFalse($this->taskModel->validate($invalidData));
        $this->assertArrayHasKey('name', $this->taskModel->errors());
    }

    public function testValidationWithEmptyDescription()
    {
        $data = [
            'name' => 'Tarefa sem descrição',
            'description' => '',
            'completed' => 'f'
        ];

        $this->assertTrue($this->taskModel->validate($data));
    }

    public function testValidationWithInvalidCompletedValue()
    {
        $data = [
            'name' => 'Tarefa com valor inválido',
            'description' => 'Descrição',
            'completed' => 'invalid'
        ];

        $this->assertFalse($this->taskModel->validate($data));
        $this->assertArrayHasKey('completed', $this->taskModel->errors());
    }

    public function testModelProperties()
    {
        $this->assertEquals('tasks', $this->taskModel->table);
        $this->assertEquals('id', $this->taskModel->primaryKey);
        $this->assertTrue($this->taskModel->useAutoIncrement);
        $this->assertEquals('array', $this->taskModel->returnType);
        
        $expectedFields = ['name', 'description', 'completed', 'deleted', 'created_at'];
        $this->assertEquals($expectedFields, $this->taskModel->allowedFields);
    }

    public function testValidationRulesStructure()
    {
        $validationRules = $this->taskModel->validationRules;
        
        $this->assertArrayHasKey('name', $validationRules);
        $this->assertArrayHasKey('description', $validationRules);
        $this->assertArrayHasKey('completed', $validationRules);
        $this->assertArrayHasKey('deleted', $validationRules);
        
        $this->assertStringContainsString('required', $validationRules['name']);
        $this->assertStringContainsString('min_length[3]', $validationRules['name']);
        $this->assertStringContainsString('max_length[100]', $validationRules['name']);
    }
} 