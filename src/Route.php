<?php
namespace Gungnir\HTTP;

use Gungnir\HTTP\Parser\UriParser;
use Gungnir\HTTP\Parser\UriParserInterface;

class Route
{
    /** @var String $uri The request uri */
    private $uri = null;

    /** @var array $options All options for route */
    private $options = null;

    /** @var UriParserInterface */
    private $uriParser = null;

    /** @var array $parameters All route specific parameters */
    private $parameters = array();

    /** @var Route[] $routes Array with route objects */
    protected static $routes = array();

    /**
     * @param String $uri     URI that route should be associated with
     * @param array  $options Route options
     */
    public function __construct(String $uri, array $options = array())
    {
        $this->uri = $uri;
        $this->options = $options;
    }

    /**
     * @return UriParserInterface
     */
    public function getUriParser(): UriParserInterface
    {
        if (empty($this->uriParser)) {
            $this->uriParser = new UriParser();
        }
        return $this->uriParser;
    }

    /**
     * @param UriParserInterface $uriParser
     */
    public function setUriParser(UriParserInterface $uriParser)
    {
        $this->uriParser = $uriParser;
    }

    /**
     * Adds a new route object to the stack of routes
     *
     * @param String $name  Name of route
     * @param Route  $route The route object
     *
     * @return void
     */
    public static function add(String $name, Route $route)
    {
        static::$routes = [ $name => $route ] + static::$routes;
    }

    /**
     * Finds a route by traversing over all registered Routes and
     * matches the incoming uri against the route's uri.
     *
     * @param  String $uri The incoming URI
     *
     * @return Route|Null
     */
    public static function find(String $uri)
    {
        foreach (static::$routes as $name => $route) {
            if ($route->match($uri)) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Matches route against incoming URI
     *
     * @param  String $uri The URI to match route against
     *
     * @return Boolean
     */
    public function match(String $uri) : bool
    {

        $explodeURI = function(string $uri): array {
            $trimmedUri = trim($uri, '/');
            if (empty($trimmedUri)) {
                return [];
            }
            return explode('/', trim($uri, '/'));
        };

        $uri = $this->getUriParser()->parse($uri);
        $uri_pieces = $explodeURI($uri);
        $route_pieces = $explodeURI($this->uri);

        foreach ($route_pieces as $key => $value) {
            if ($this->matchPieces($key, $value, $uri_pieces) === false) {
                $this->parameters = array();
                return false;
            }
        }
        return true;
    }

    /**
     * Get all route parameters
     *
     * @return array
     */
    public function parameters() : array
    {
        return $this->parameters;
    }

    /**
     * Get a specific parameter
     *
     * @param  String $name Name of the parameter
     *
     * @return Mixed
     */
    public function parameter(String $name)
    {
        return $this->parameters[$name] ?? false;
    }

    /**
     * Get a specific option for the route
     *
     * @param  String $name Option key
     *
     * @return Mixed
     */
    public function option(String $name)
    {
        return $this->options[$name] ?? false;
    }

    /**
     * Get all route options
     *
     * @return array
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Get controller name from route
     *
     * @return String Name of controller
     */
    public function controller() : String
    {
        $controller = $this->parameter('controller');
        $controller = empty($controller) ? $this->option('controller') : $controller;
        return $this->options['namespace'] . ucfirst($controller);
    }

    /**
     * Get action name from route
     *
     * @return String Name of action
     */
    public function action() : String
    {
        $action = $this->parameter('action');
        $action = empty($action) ? $this->option('action') : $action;
        return ucfirst($action);
    }

    /**
     * Checks whether or not passed action is valid based
     * on defined actions in route configuration
     *
     * @param String $action
     *
     * @return Bool
     */
    public function isActionValid(String $action) : Bool
    {
        $actions = (empty($this->option('actions'))) ? [] : $this->option('actions');
        if (empty($actions) === false && in_array($action, $actions) === false) {
            return false;

        }
        return true;
    }

    /**
     * Matches an route uri piece to incoming uri_pieces. If parameter is found
     * it's set in the route parameter array
     *
     * @param  String $key        Route piece key
     * @param  Mixed  $value      Route piece to match
     * @param  array $uri_pieces  URI pieces to match with
     *
     * @return boolean True if piece is present else false
     */
    private function matchPieces($key, $value, array $uri_pieces = array())
    {
        if (strpos($value, ':') !== false) {
            $parameter = ltrim($value, ':');
            $this->parameters[$parameter] = $uri_pieces[$key] ?? $this->options['defaults'][$parameter] ?? false;
        } elseif( empty($uri_pieces[$key]) || $value !== $uri_pieces[$key] ) {
            return false;
        }
        return true;
    }
}
