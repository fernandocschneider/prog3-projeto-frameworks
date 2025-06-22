<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;

class SimpleTaskTest extends CIUnitTestCase
{
    public function testTaskDataStructure()
    {
        $task = [
            'id' => 1,
            'name' => 'Tarefa de Teste',
            'description' => 'Descrição da tarefa',
            'completed' => 'f',
            'deleted' => 'f',
            'created_at' => '2025-06-22 00:00:00'
        ];

        $this->assertArrayHasKey('id', $task);
        $this->assertArrayHasKey('name', $task);
        $this->assertArrayHasKey('description', $task);
        $this->assertArrayHasKey('completed', $task);
        $this->assertArrayHasKey('deleted', $task);
        $this->assertArrayHasKey('created_at', $task);

        $this->assertIsInt($task['id']);
        $this->assertIsString($task['name']);
        $this->assertIsString($task['description']);
        $this->assertIsString($task['completed']);
        $this->assertIsString($task['deleted']);
        $this->assertIsString($task['created_at']);
    }

    public function testTaskValidationLogic()
    {
        $validTask = [
            'name' => 'Tarefa Válida',
            'description' => 'Descrição válida',
            'completed' => 'f'
        ];

        $invalidTask = [
            'name' => 'Ab',
            'description' => 'Descrição',
            'completed' => 'invalid'
        ];

        $isValidTask = $this->validateTask($validTask);
        $isInvalidTask = $this->validateTask($invalidTask);

        $this->assertTrue($isValidTask);
        $this->assertFalse($isInvalidTask);
    }

    public function testTaskStatusToggle()
    {
        $task = [
            'id' => 1,
            'completed' => 'f'
        ];

        $task['completed'] = $this->toggleStatus($task['completed']);
        $this->assertEquals('t', $task['completed']);

        $task['completed'] = $this->toggleStatus($task['completed']);
        $this->assertEquals('f', $task['completed']);
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

    private function validateTask($task)
    {
        if (strlen($task['name']) < 3) {
            return false;
        }
        
        if (!in_array($task['completed'], ['t', 'f'])) {
            return false;
        }

        return true;
    }

    private function toggleStatus($currentStatus)
    {
        return $currentStatus === 'f' ? 't' : 'f';
    }
} 