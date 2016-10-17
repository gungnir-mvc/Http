<?php
namespace Gungnir\HTTP\Tests;

use Gungnir\HTTP\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function testItRoutesUriToCorrectRoute()
    {
        $route = new Route('/testRoute/:controller/:action', [
            'namespace' => '\Gungnir\Test\Controller\\',
            'defaults' => [
                'controller' => 'index',
                'action' => 'index'
            ]
        ]);

        Route::add('testRoute', $route);

        $match = Route::find('/testRoute');

        $this->assertEquals($route, $match);

        $this->assertEquals('\Gungnir\Test\Controller\Index', $match->controller());
        $this->assertEquals('Index', $match->action());

        $match2 = Route::find('/testRoute/customcontroller/customaction');

        $this->assertEquals('\Gungnir\Test\Controller\Customcontroller', $match2->controller());
        $this->assertEquals('Customaction', $match2->action());
    }
}
