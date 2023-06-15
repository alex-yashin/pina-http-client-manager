<?php

use PHPUnit\Framework\TestCase;
use PinaHttpClientManager\Model\ClientConfiguration;

class ScopeTest extends TestCase
{
    public function testScopeValues()
    {
        $config = new ClientConfiguration('http://localhost/', '123', 'orders currency:USD currency:RUB');
        $expected = ['USD', 'RUB'];
        $this->assertEquals($expected, $config->getScopeValues('currency'));

        $this->assertTrue($config->isValid('123', ['orders']));
        $this->assertFalse($config->isValid('123', ['products']));
        $this->assertFalse($config->isValid('234', ['orders']));
        $this->assertFalse($config->isValid('', ['orders']));
        $this->assertFalse($config->isValid('', []));
    }
}