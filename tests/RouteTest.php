<?php
namespace Gungnir\HTTP\Tests;

use Gungnir\HTTP\Route;
use \PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{


    /**
     * @test
     */
    public function sometest()
    {
        $route1 = new Route('/x', [
            'namespace' => 'x'
        ]);

        $route2 = new Route('/x/:y', [
            'namespace' => 'xy',
            'defaults' =>[
                'y' => false,
            ]
        ]);

        Route::add('route2', $route2);
        Route::add('route1', $route1);


        $this->assertEquals($route1->options(), Route::find('/x')->options(), 'uri /x did not match correct route');
        $this->assertEquals($route2->options(), Route::find('/x/_y')->options(), 'uri /x/_y did not match correct route');
        
    }

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
