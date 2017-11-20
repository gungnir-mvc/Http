<?php
namespace Gungnir\HTTP;


interface RequestProtocolInterface
{
    /**
     * Returns a string value of current request protocol
     *
     * @return string
     */
    public function getProtocolString(): string;

    /**
     * Determines if current request protocol is secure (https)
     * or not.
     *
     * @return bool
     */
    public function isProtocolSecure(): bool;
}