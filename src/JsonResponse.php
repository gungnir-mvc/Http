<?php
namespace Gungnir\HTTP;

class JsonResponse extends Response
{
    /**
     * @param mixed $body           Array or string. Arrays get's encoded to json
     * @param int   $httpStatusCode The status to set in the response
     */
    public function __construct($body = null, Int $httpStatusCode = null)
    {
        if (is_array($body)) {
            $body = json_encode($body);
        }

        $this->setHeader('Content-Type', 'application/json');
        parent::__construct($body, $httpStatusCode);
    }
}
