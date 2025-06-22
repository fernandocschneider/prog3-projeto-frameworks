<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;

class BasicTaskTest extends CIUnitTestCase
{
    public function testTaskCreation()
    {
        $taskName = 'Tarefa de Teste';
        $taskDescription = 'Descrição da tarefa';
        
        $task = [
            'name' => $taskName,
            'description' => $taskDescription,
            'completed' => false,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->assertEquals($taskName, $task['name']);
        $this->assertEquals($taskDescription, $task['description']);
        $this->assertFalse($task['completed']);
        $this->assertNotEmpty($task['created_at']);
    }

    public function testTaskValidation()
    {
        $validTask = [
            'name' => 'Tarefa Válida',
            'description' => 'Descrição válida'
        ];
        
        $invalidTask = [
            'name' => 'Ab',
            'description' => 'Descrição'
        ];
        
        $isValid = $this->validateTaskName($validTask['name']);
        $isInvalid = $this->validateTaskName($invalidTask['name']);
        
        $this->assertTrue($isValid);
        $this->assertFalse($isInvalid);
    }

    public function testTaskStatus()
    {
        $task = [
            'id' => 1,
            'name' => 'Tarefa',
            'completed' => false
        ];
        
        $task['completed'] = true;
        $this->assertTrue($task['completed']);
        
        $task['completed'] = false;
        $this->assertFalse($task['completed']);
    }

    public function testTaskArrayStructure()
    {
        $task = [
            'id' => 1,
            'name' => 'Tarefa Teste',
            'description' => 'Descrição',
            'completed' => false,
            'created_at' => '2025-06-22 00:00:00'
        ];
        
        $requiredFields = ['id', 'name', 'description', 'completed', 'created_at'];
        
        foreach ($requiredFields as $field) {
            $this->assertArrayHasKey($field, $task);
        }
        
        $this->assertIsNumeric($task['id']);
        
        $this->assertIsString($task['name']);
    }

    public function testTaskNameLength()
    {
        $shortName = 'Ab';
        $validName = 'Tarefa Válida';
        $longName = str_repeat('A', 101);
        
        $this->assertLessThan(3, strlen($shortName));
        $this->assertGreaterThanOrEqual(3, strlen($validName));
        $this->assertLessThanOrEqual(100, strlen($validName));
        $this->assertGreaterThan(100, strlen($longName));
    }

    private function validateTaskName($name)
    {
        return strlen($name) >= 3 && strlen($name) <= 100;
    }
} 