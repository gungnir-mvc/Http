<?php
namespace Gungnir\HTTP\Tests;

use Gungnir\HTTP\ParameterBag;
use \PHPUnit\Framework\TestCase;

class ParameterBagTest extends TestCase
{
    public function testItStoresAndRetrievesCorrectly()
    {
        $expectedParametersStored = [
            'foo' => 'bar',
            'fizz' => 'buzz',
            'bizz' => 'bazz'
        ];

        $parameterBag = new ParameterBag;

        foreach ($expectedParametersStored as $key => $value) {
            $parameterBag->set($key, $value);
            $this->assertEquals($value, $parameterBag->get($key));
        }

        $this->assertEquals($expectedParametersStored, $parameterBag->parameters());
    }

    public function testItDeletesCorrectly()
    {
        $expectedParametersStored = [
            'foo' => 'bar',
            'fizz' => 'buzz',
            'bizz' => 'bazz'
        ];

        $parameterBag = new ParameterBag($expectedParametersStored);

        foreach ($expectedParametersStored as $key => $value) {
            $this->assertTrue($parameterBag->has($key));
            $parameterBag->delete($key);
            $this->assertFalse($parameterBag->has($key));
        }
    }
}
