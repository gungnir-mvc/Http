<?php
namespace Gungnir\HTTP;

class Route
{
    /** @var String $uri The request uri */
    private $uri = null;

    /** @var Array $options All options for route */
    private $options = null;

    /** @var array $parameters All route specific parameters */
    private $parameters = array();

    /** @var array $routes Array with route objects */
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
        $uri = $this->parseUri($uri);
        $uri_pieces     = empty(trim($uri, '/')) ? [] : explode('/', trim($uri, '/'));
        $route_pieces     = explode('/', ltrim($this->uri, '/'));
        
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
     * Parses an uri to enable easier matching with route.
     * Removes base directory in addition to index.php if present.
     * Trailing slashes and queries.
     *
     * @param  String $uri Incoming URI
     * @return String      Modified URI
     */
    private function parseUri(String $uri)
    {
        $uri = parse_url($uri,  PHP_URL_PATH);

        if (defined('BASE_DIR')) {
            $uri = str_replace(BASE_DIR, '', $uri);
        }

        $uri = str_replace('index.php', '', $uri);
        $uri = trim($uri, '/');
        return $uri;
    }

    /**
     * Matches an route uri piece to incoming uri_pieces. If parameter is found
     * it's set in the route parameter array
     *
     * @param  String $key        Route piece key
     * @param  Mixed  $value      Route piece to match
     * @param  Array $uri_pieces  URI pieces to match with
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
