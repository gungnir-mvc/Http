<?php
namespace Gungnir\HTTP\Tests;

use Gungnir\HTTP\Request;
use \PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * This test more or less just checks so that all the different
     * parameterbags have been correctly created and that the initialize
     * method have been invoked.
     *
     * @test
     */
    public function testItInitializesCorrectly()
    {
        $key   = 'foo';
        $value = 'bar';

        $godArray = [$key => $value];

        $request = new Request($godArray, $godArray, $godArray, $godArray, $godArray, $godArray);

        $this->assertEquals($request->query()->get($key), $value);
        $this->assertEquals($request->request()->get($key), $value);
        $this->assertEquals($request->parameters()->get($key), $value);
        $this->assertEquals($request->cookies()->get($key), $value);
        $this->assertEquals($request->files()->get($key), $value);
        $this->assertEquals($request->server()->get($key), $value);
    }
}
