<?php
namespace Gungnir\HTTP;

class Response {

    /** @var String $body The actual content that will be displayed */
    private $body = null;

    /** @var Integer $httpStatusCode The code that corresponds to response status */
    private $httpStatusCode = null;

    /** @var Array $headers Headers to send with the response */
    private $headers = array();

    /**
     * Following are constans for all the different status codes
     * bound to their numerical value. These can be used to set
     * status codes you know are correct in addition for the Response
     * object to actually find correct status code messages.
     */
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_LOCKED = 423;                                                      // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

    /**
     * Numerically indexed array where the key is an actual
     * HTTP status code that has a status messages bound to it.
     * @var array
     */
    public static $statusTexts = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',            // RFC2518
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',          // RFC4918
            208 => 'Already Reported',      // RFC5842
            226 => 'IM Used',               // RFC3229
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',    // RFC7238
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large',
            414 => 'URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',                                               // RFC2324
            422 => 'Unprocessable Entity',                                        // RFC4918
            423 => 'Locked',                                                      // RFC4918
            424 => 'Failed Dependency',                                           // RFC4918
            425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
            426 => 'Upgrade Required',                                            // RFC2817
            428 => 'Precondition Required',                                       // RFC6585
            429 => 'Too Many Requests',                                           // RFC6585
            431 => 'Request Header Fields Too Large',                             // RFC6585
            451 => 'Unavailable For Legal Reasons',                               // RFC7725
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates (Experimental)',                      // RFC2295
            507 => 'Insufficient Storage',                                        // RFC4918
            508 => 'Loop Detected',                                               // RFC5842
            510 => 'Not Extended',                                                // RFC2774
            511 => 'Network Authentication Required',                             // RFC6585
        );

    /**
     * @param String  $body           String to set as response body
     * @param Integer $httpStatusCode String to set as HTTP response code
     */
    public function __construct(String $body = null,Int $httpStatusCode = null)
    {
        $this->setBody($body ?? "");
        $this->statusCode($httpStatusCode ?? self::HTTP_OK);
    }

    /**
     * Casts the object to a response string that is the actual
     * output generated for output in browser
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->output();
    }

    /**
     * Set the response body
     *
     * @param String $body Body that will be outputted
     *
     * @return Response
     */
    public function setBody(String $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Get the body that should be outputted
     *
     * @return String Body that should be outputted
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * Gets or sets the HTTP status code that should be used for outputting
     * the response
     *
     * @param  Integer $httpStatusCode Status code
     *
     * @return Integer|Response
     */
    public function statusCode(Int $httpStatusCode = null)
    {
        if ($httpStatusCode) {
            $this->httpStatusCode = $httpStatusCode;
            $this->setHttpHeader($httpStatusCode);
            return $this;
        }
        return $this->httpStatusCode;
    }

    /**
     * Gets or sets all headers that should be used for outputting
     * the response
     *
     * @param  Array $headers The headers to be set
     *
     * @return Array|Response
     */
    public function headers(Array $headers = null)
    {
        if ($headers) {
            $this->headers = $headers;
            return $this;
        }

        return $this->headers;
    }

    /**
     * Sets the specific HTTP/1.1 header to the statusCode
     * and automatically sets the corresponding status message
     * also
     *
     * @param Int $statusCode The given statusCode to set
     *
     * @return Response
     */
    public function setHttpHeader(Int $statusCode)
    {
        $this->setHeader('HTTP/1.1', $statusCode . ' ' . self::$statusTexts[$statusCode]);
        return $this;
    }

    /**
     * Sets a single given header to a given value which
     * later will be used to output the response
     *
     * @param String $key   Header key
     * @param String $value Header value
     *
     * @return Response
     */
    public function setHeader(String $key, String $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Get a single given header registered under given key
     *
     * @param  String $key Header key
     *
     * @return String|Boolean
     */
    public function getHeader(String $key)
    {
        return $this->headers[$key] ?? false;
    }

    /**
     * Generates the complete response body with headers and
     * body.
     *
     * @return String The complete body string
     */
    public function output()
    {
        $this->applyHeaders();

        return $this->getBody();
    }

    /**
     * Sets everything that is necessary for doing a redirect
     *
     * @param  String $uri The uri to redirect to
     *
     * @return void
     */
    public function redirect(String $uri)
    {
        $this->setHeader('Location', $uri);
        $this->httpStatusCode = 301;
    }

    /**
     * Checks if current response is a redirect
     *
     * @return boolean True if redirect else False
     */
    public function isRedirect()
    {
        return $this->httpStatusCode > 299 && $this->httpStatusCode < 400;
    }

    /**
     * Applies all registered headers to HTTP response header
     *
     * @return void
     */
    private function applyHeaders()
    {
        foreach ($this->headers() as $key => $value) {
            if ($key == 'HTTP/1.1') {
                header($key . ': ' . $value, true, $this->statusCode());
                continue;
            }
            header($key.': ' . $value);
        }
    }

}
