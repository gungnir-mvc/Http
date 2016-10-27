<?php
namespace Gungnir\HTTP;

class Request
{
    /** @var ParameterBag $query All query parameters */
    private $query = null;

    /** @var ParameterBag $request All request/post parameters */
    private $request = null;

    /** @var ParameterBag $parameters All route specified parameters */
    private $parameters = null;

    /** @var ParameterBag $files All files associated with request */
    private $files = null;

    /** @var ParameterBag $cookies All cookies associated with request */
    private $cookies = null;

    /** @var ParameterBag $server All server variables registered */
    private $server = null;

    /** @var ParameterBag $headers All headers associated with request */
    private $headers = null;

    /**
     * Constructor takes multiple arrays for different purpouses which
     * is used through out the whole Request flow. Constructor calls
     * the class method `initialize` which converts arrays to ParameterBags
     * and binds them to class attributes
     *
     * @param array $query      Query parameters
     * @param array $request    Request/Post parameters
     * @param array $parameters Route specific parameters
     * @param array $cookies    Request cookies
     * @param array $files      Request files
     * @param array $server     Server variables
     */
    public function __construct(
        array $query      = array(),
        array $request    = array(),
        array $parameters = array(),
        array $cookies    = array(),
        array $files      = array(),
        array $server     = array()
        )
    {
        $this->initialize($query, $request, $parameters, $cookies, $files, $server);
    }

    /**
     * Takes multiple arrays and converts them to ParameterBags in
     * addition to binding them to class attributes
     *
     * @param array $query         Query parameters
     * @param array $request     Request/Post parameters
     * @param array $parameters Route specific parameters
     * @param array $cookies     Request cookies
     * @param array $files         Request files
     * @param array $server     Server variables
     *
     * @return Request
     */
    public function initialize(
        array $query      = array(),
        array $request    = array(),
        array $parameters = array(),
        array $cookies    = array(),
        array $files      = array(),
        array $server     = array()
        )
    {
        $this->query      = new ParameterBag($query);
        $this->request    = new ParameterBag($request);
        $this->parameters = new ParameterBag($parameters);
        $this->files      = new ParameterBag($files);
        $this->cookies    = new ParameterBag($cookies);
        $this->server     = new ParameterBag($server);

        return $this;
    }

    /**
     * Return the ParameterBag for Query parameters
     *
     * @return ParameterBag
     */
    public function query() : ParameterBag
    {
        return $this->query;
    }

    /**
    * Return the ParameterBag for Route specific parameters
    *
    * @return ParameterBag
    */
    public function parameters() : ParameterBag
    {
        return $this->parameters;
    }

    /**
    * Return the ParameterBag for Request/Post parameters
    *
    * @return ParameterBag
    */
    public function request() : ParameterBag
    {
        return $this->request;
    }

    /**
    * Return the ParameterBag for Server parameters
    *
    * @return ParameterBag
    */
    public function server() : ParameterBag
    {
        return $this->server;
    }

    /**
    * Return the ParameterBag for Cookies
    *
    * @return ParameterBag
    */
    public function cookies() : ParameterBag
    {
        return $this->cookies;
    }

    /**
    * Return the ParameterBag for Files
    *
    * @return ParameterBag
    */
    public function files() : ParameterBag
    {
        return $this->files;
    }

}