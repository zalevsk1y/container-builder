<?php

use PHPUnit\Framework\TestCase;
use ContainerBuilder\DI;

class DITest extends TestCase
{
    public function testAddService()
    {
        $di = new DI();
        $di->addService('logger', function() {
            return new Logger();
        });
        $this->assertInstanceOf(Logger::class, $di->getService('logger'));
    }

    public function testGetServiceThrowsExceptionWhenServiceNotFound()
    {
        $di = new DI();
        $this->expectException(DI\ServiceNotFoundException::class);
        $di->getService('logger');
    }

    public function testGetServiceThrowsExceptionWhenServiceIsNotCallable()
    {
        $di = new DI();
        $di->addService('logger', new Logger());
        $this->expectException(DI\ServiceNotCallableException::class);
        $di->getService('logger');
    }
}
