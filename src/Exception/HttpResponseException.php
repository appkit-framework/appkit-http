<?php

namespace AppKit\Http\Exception;

use Exception;

class HttpResponseException extends Exception {
    protected const STATUS_MESSAGE = [
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
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
        426 => 'Upgrade Required',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    ];

    function __construct($status = 500, $message = null, $previous = null, $headers = []) {
        parent::__construct(
            $message ?? self::STATUS_MESSAGE[$status] ?? 'Unknown Status',
            $status,
            $previous
        );
        $this -> headers = $headers;
    }

    public function getHeader($name) {
        return $this -> headers[$name] ?? null;
    }

    public function getHeaders() {
        return $this -> headers;
    }

    public function withHeader($name, $value) {
        $new = clone $this;
        $new -> headers[$name] = $value;
        return $new;
    }

    public function withoutHeader($name) {
        $new = clone $this;
        unset($new -> headers[$name]);
        return $new;
    }
}
