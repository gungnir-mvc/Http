<?php
namespace Gungnir\HTTP\Tests;

use Gungnir\HTTP\Request;
use Gungnir\HTTP\RequestProtocol;
use PHPUnit\Framework\TestCase;

class RequestProtocolTest extends TestCase
{

    /**
     * @test
     */
    public function itReturnsHttpWhenRequestProtocolIsNotSecure()
    {

        $request = new Request([],[],[],[],[],['SERVER_PORT' => 80]);

        $protocol = new RequestProtocol($request);
        $this->assertFalse($protocol->isProtocolSecure());
        $this->assertEquals('http://', $protocol->getProtocolString());
    }

    /**
     * @test
     */
    public function itReturnsHttpsWhenRequestProtocolIsSecure()
    {
        $request = new Request([],[],[],[],[],['SERVER_PORT' => 443]);

        $protocol = new RequestProtocol($request);
        $this->assertTrue($protocol->isProtocolSecure());
        $this->assertEquals('https://', $protocol->getProtocolString());
    }

}