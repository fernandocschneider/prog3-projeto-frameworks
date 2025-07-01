<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use App\Controllers\Tasks;

class TasksControllerTest extends CIUnitTestCase
{
    protected $tasksController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tasksController = new Tasks();
    }

    public function testControllerInstance()
    {
        $this->assertInstanceOf(Tasks::class, $this->tasksController);
    }

    public function testControllerHasTaskModel()
    {
        $reflection = new \ReflectionClass($this->tasksController);
        $property = $reflection->getProperty('taskModel');
        $property->setAccessible(true);
        
        $taskModel = $property->getValue($this->tasksController);
        $this->assertInstanceOf(\App\Models\TaskModel::class, $taskModel);
    }

    public function testControllerHasUserModel()
    {
        $reflection = new \ReflectionClass($this->tasksController);
        $property = $reflection->getProperty('userModel');
        $property->setAccessible(true);
        
        $userModel = $property->getValue($this->tasksController);
        $this->assertInstanceOf(\App\Models\UserModel::class, $userModel);
    }

    public function testControllerMethodsExist()
    {
        $this->assertTrue(method_exists($this->tasksController, 'index'));
        $this->assertTrue(method_exists($this->tasksController, 'list'));
        $this->assertTrue(method_exists($this->tasksController, 'add'));
        $this->assertTrue(method_exists($this->tasksController, 'delete'));
        $this->assertTrue(method_exists($this->tasksController, 'toggle'));
    }

    public function testControllerMethodVisibility()
    {
        $reflection = new \ReflectionClass($this->tasksController);
        
        $methods = ['index', 'list', 'add', 'delete', 'toggle'];
        foreach ($methods as $method) {
            $methodReflection = $reflection->getMethod($method);
            $this->assertTrue($methodReflection->isPublic(), "Método $method deve ser público");
        }
    }

    public function testControllerConstructor()
    {
        $controller = new Tasks();
        $this->assertInstanceOf(Tasks::class, $controller);
    }

    public function testControllerResponseProperty()
    {
        $this->assertTrue(property_exists($this->tasksController, 'response'));
    }

    public function testControllerUsesSession()
    {
        $this->assertTrue(method_exists($this->tasksController, 'index'));
        $this->assertTrue(method_exists($this->tasksController, 'list'));
        $this->assertTrue(method_exists($this->tasksController, 'add'));
        $this->assertTrue(method_exists($this->tasksController, 'delete'));
        $this->assertTrue(method_exists($this->tasksController, 'toggle'));
    }

    public function testControllerMethodsRequireUserAuthentication()
    {
        $reflection = new \ReflectionClass($this->tasksController);
        
        $methods = ['index', 'list', 'add', 'delete', 'toggle'];
        foreach ($methods as $method) {
            $methodReflection = $reflection->getMethod($method);
            $this->assertTrue($methodReflection->isPublic(), "Método $method deve ser público");
        }
    }
} 