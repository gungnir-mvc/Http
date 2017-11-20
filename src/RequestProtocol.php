<?php
namespace Gungnir\HTTP;

/**
 * Class RequestProtocol represents the current protocol and contains
 * the logic to determine it for re-usage throughout applications.
 *
 * @package Gungnir\HTTP
 */
class RequestProtocol implements RequestProtocolInterface
{
    /** @var Request */
    private $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Magic string casting method. Returns the same value as
     * getProtocolString method.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getProtocolString();
    }

    /**
     * Returns a string value of current protocol
     *
     * @return string
     */
    public function getProtocolString(): string
    {
        if ($this->isProtocolSecure()) {
            return 'https://';
        }
        return 'http://';
    }

    /**
     * @inheritDoc
     */
    public function isProtocolSecure(): bool
    {
        return (!empty($this->request->server()->get('HTTPS')) && $this->request->server()->get('HTTPS') !== 'off')
        || $this->request->server()->get('SERVER_PORT') == 443;
    }

}