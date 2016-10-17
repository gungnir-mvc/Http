<?php
namespace Gungnir\HTTP\Tests;

use Gungnir\HTTP\JsonResponse;

class JsonResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testItEncodesDataCorrectly()
    {
        $stdObj = new \StdClass();
        $stdObj->bizz = 'buzz';
        $data = [
            'foo' => 'bar',
            'object' => $stdObj
        ];

        $expected = json_encode($data);

        $response = new JsonResponse($data);

        $this->assertEquals($expected, $response->getBody());
    }
}
