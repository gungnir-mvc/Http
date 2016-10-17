<?php
namespace Gungnir\HTTP;

class ParameterBag
{
    /** @var Array [description] */
    private $parameters = array();

    /**
     * @param array|null $parameters If array is passed it will be set as parameters
     */
    public function __construct(array $parameters = null)
    {
        if ($parameters) {
            $this->parameters = $parameters;
        }
    }

    /**
     * Checks if a certain parameter is registered
     *
     * @param  String  $name Name of parameter to check for
     * @return boolean
     */
    public function has(String $name)
    {
        return isset($this->parameters[$name]);
    }

    /**
     * Retrieves the parameter stored under name
     *
     * @param  String $name Name of parameter to get
     * @return Mixed Who Knows?
     */
    public function get(String $name)
    {
        return $this->has($name) ? $this->parameters[$name] : false;
    }

    /**
     * Stores a parameter under specified name
     *
     * @param String $name Name to store parameter under
     * @param mixed  $item Parameter to store
     * @return ParameterBag
     */
    public function set(String $name, $item) : ParameterBag
    {
        $this->parameters[$name] = $item;
        return $this;
    }

    /**
     * Removes parameter by specified name
     * @param  String $name Name of parameter to delete
     * @return ParameterBag
     */
    public function delete(String $name) : ParameterBag
    {
        if ($this->has($name)) {
            unset($this->parameters[$name]);
        }

        return $this;
    }

    /**
     * Get all current parameters in bag
     *
     * @return array All
     */
    public function parameters()
    {
        return $this->parameters;
    }
}
