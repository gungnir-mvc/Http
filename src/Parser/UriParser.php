<?php
namespace Gungnir\HTTP\Parser;

class UriParser implements UriParserInterface
{
    /**
     * Parses an uri
     *
     * @param string $input
     *
     * @return string
     */
    public function parse(string $uri): string
    {
        $uri = parse_url($uri,  PHP_URL_PATH);

        if (defined('BASE_DIR')) {
            $uri = str_replace(BASE_DIR, '', $uri);
        }

        $uri = str_replace('index.php', '', $uri);
        $uri = trim($uri, '/');
        return $uri;
    }
}