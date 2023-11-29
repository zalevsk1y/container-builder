<?php

use ContainerBuilder\DI;
use ContainerBuilder\Exception\MyException;
use ContainerBuilder\Message\Errors;
use PHPUnit\Framework\TestCase;

class MockClass {
    public $val=0;
}
class MockClass1 {
    public function _construct(MockClass $mock_class)
    {}
}
class MockClass2 {
    public function _construct(string $str)
    {}
}
class MockClass3 {
    public function _construct(MockClass $mock_class)
    {}
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
        $this->expectExceptionMessage(Errors::text('NO_DI_DEFINITION_FILE'));
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
        $instance_mock_class = $di->get(MockClass::class);
        $this->assertInstanceOf(MockClass::class, $instance_mock_class);

        // Test getting an instance that exists in the definition array
        $instance_mock_class1 = $di->get(MockClass1::class);
        $this->assertInstanceOf(MockClass1::class, $instance_mock_class1);

        // Test getting an instance that exists in the definition array
        $instance_mock_class2 = $di->get(MockClass2::class);
        $this->assertInstanceOf(MockClass2::class, $instance_mock_class2);

        $instance_mock_class->val1=2;
        $same_instance_mock_class=$di->get(MockClass::class);
        $this->assertEquals(2, $same_instance_mock_class->val1);

        
        // Test getting an instance that does not exist in the definition array
        $this->expectException(MyException::class);
        $this->expectExceptionMessage(Errors::text('NO_NEEDED_DEPENDENCY_IN_DEFINITION'));
        $di->get(NonMockedClass::class);
    }
    public function testSet()
    {
        $di = new DI();
        $pathToDefinitionFile = __DIR__.'/../mock/di-config.php';
        $di->addDefinitions($pathToDefinitionFile);
        
        // Test getting an instance that exists in the definition array
        $di->set(new MockClass3($di->get(MockClass::class)));
        $instance = $di->get(MockClass3::class);
        $this->assertInstanceOf(MockClass3::class, $instance);
        
    }
}
