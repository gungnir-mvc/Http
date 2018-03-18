<?php
namespace Gungnir\HTTP\Tests;

use Gungnir\HTTP\Route;
use \PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /**
     * @test
     * 
     * @dataProvider uriRoutingProvider
     */
    public function itRoutesUriCorrectly(Route $route, string $uri)
    {

        Route::add('testingRoute', $route);

        $match = Route::find($uri);

        $this->assertEquals($route, $match);

        $this->assertEquals($route->controller(), $match->controller());
        $this->assertEquals($route->action(), $match->action());

    }

    public function uriRoutingProvider()
    {
        $route1 = new Route('/testRoute/:controller/:action', [
            'namespace' => '\Gungnir\Test\Controller\\',
            'defaults' => [
                'controller' => 'index',
                'action' => 'index'
            ]
        ]);

        $route2 = new Route('/', [
            'namespace' => '\Gungnir\Test\Controller\\',
            'defaults' => [
                'controller' => 'index',
                'action' => 'index'
            ]
        ]);

        return [
            [$route1, "/testRoute"],
            [$route2, "/"]
        ];
    }

    /**
     * @test
     */
    public function itValidatesActionCorrectly()
    {
        $route = new Route('/testRoute/:controller/:action', [
            'namespace' => '\Gungnir\Test\Controller\\',
            'actions'=> [
                'getIndex'
            ],
            'defaults' => [
                'controller' => 'index',
                'action' => 'index'
            ]
        ]);

        $this->assertTrue($route->isActionValid('getIndex'));
        $this->assertFalse($route->isActionValid('getContainer'));
    }
}
