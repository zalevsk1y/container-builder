<?php

use ContainerBuilder\DI;
use ContainerBuilder\Exception\MyException;
use ContainerBuilder\Message\Errors;
use PHPUnit\Framework\TestCase;

class MockClass {
    
}

class DITest extends TestCase
{
    public function testAddDefinitions()
    {
        $di = new DI();
        $pathToDefinitionFile = __DIR__.'/../mock/di-config.php';
        
        // Test that adding valid definitions does not throw an exception
        $this->assertNull($di->addDefinitions($pathToDefinitionFile));
        
        // Test that adding non-existent definition file throws an exception
        $this->expectException(MyException::class);
        $this->expectExceptionMessage(Errors::text('NO_DI_DEFENITION_FILE'));
        $di->addDefinitions('nonexistent/file.php');
    }
    
    // Write more test methods to cover other methods in the DI class
    
    // Example of a test method for the get() method
    public function testGet()
    {
        $di = new DI();
        $pathToDefinitionFile = __DIR__.'/../mock/di-config.php';
        $di->addDefinitions($pathToDefinitionFile);
        
        // Test getting an instance that exists in the definition array
        $instance = $di->get(MockClass::class);
        $this->assertInstanceOf(MockClass::class, $instance);
        
        // Test getting an instance that does not exist in the definition array
        $this->expectException(MyException::class);
        $this->expectExceptionMessage(Errors::text('NO_NEEDED_DEPENDENCY_IN_DEFENITION'));
        $di->get(NonMockedClass::class);
    }
}
