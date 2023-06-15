<?php

use PHPUnit\Framework\TestCase;
use PinaHttpClientManager\ClientConfig;

class ScopeTest extends TestCase
{
    public function testScopeValues()
    {
        $expected = ['USD', 'RUB'];
        $scopes = ClientConfig::getScopeValues(
            ['orders', 'currency:USD', 'currency:RUB'],
            'currency'
        );
        $this->assertEquals($expected, $scopes);
    }
}