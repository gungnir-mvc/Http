<?php
namespace Gungnir\HTTP\Parser;

interface UriParserInterface
{
    /**
     * Parses an uri
     *
     * @param string $input
     *
     * @return string
     */
    public function parse(string $input): string;
}