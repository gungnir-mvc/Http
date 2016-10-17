<?php
namespace Gungnir\HTTP\Tests;

use Gungnir\HTTP\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyInstantiationResultsInEmpty200Response()
    {
        $response = new Response;
        $this->assertEquals('', $response->getBody());
        $this->assertEquals(200, $response->statusCode());
    }

    public function testResponseWithStatusCodeBetween299And400IsRecognizedAsRedirect()
    {
        $response = new Response('', Response::HTTP_OK);
        $this->assertFalse($response->isRedirect());

        $response->statusCode(Response::HTTP_TEMPORARY_REDIRECT);
        $this->assertTrue($response->isRedirect());
    }

    public function testHeadersAreApplied()
    {
        $response = new Response('foo');
        $response->setHeader('biz', 'baz');
        $headers = $response->headers();
        $this->assertArrayHasKey('HTTP/1.1', $headers);
        $this->assertArrayHasKey('biz', $headers);
        $this->assertEquals('foo', $response->getBody());
    }
}
