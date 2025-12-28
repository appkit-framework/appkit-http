<?php

namespace AppKit\Http\Message;

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

    protected $headers;
    protected $headerNames;

    function __construct($status, $message = null, $headers = [], $previous = null) {
        parent::__construct(
            $message ?? self::STATUS_MESSAGE[$status] ?? 'Unknown Status',
            $status,
            $previous
        );

        $this -> headers = [];
        $this -> headerNames = [];
        foreach($headers as $name => $value) {
            if($value !== []) {
                if(is_array($value)) {
                    foreach($value as &$one)
                        $one = (string) $one;
                } else {
                    $value = [(string) $value];
                }

                $nameLower = strtolower($name);
                if(isset($this -> headerNames[$nameLower])) {
                    $value = array_merge(
                        $this -> headers[$this -> headerNames[$nameLower]],
                        $value
                    );
                    unset($this -> headers[$this -> headerNames[$nameLower]]);
                }

                $this -> headers[$name] = $value;
                $this -> headerNames[$nameLower] = $name;
            }
        }
    }

    public function getHeaders() {
        return $this -> headers;
    }

    public function hasHeader($name) {
        return isset($this -> headerNames[strtolower($name)]);
    }

    public function getHeader($name) {
        $nameLower = strtolower($name);
        return isset($this -> headerNames[$nameLower])
            ? $this -> headers[$this -> headerNames[$nameLower]]
            : [];
    }

    public function getHeaderLine($name) {
        return implode(', ', $this -> getHeader($name));
    }

    public function withHeader($name, $value) {
        if($value === []) {
            return $this -> withoutHeader($name);
        } else if(is_array($value)) {
            foreach ($value as &$one)
                $one = (string) $one;
        } else {
            $value = [(string) $value];
        }

        $nameLower = strtolower($name);
        if(
            isset($this -> headerNames[$nameLower]) &&
            $this -> headerNames[$nameLower] === (string) $name &&
            $this -> headers[$this -> headerNames[$nameLower]] === $value
        ) {
            return $this;
        }

        $new = clone $this;
        if(isset($new -> headerNames[$nameLower]))
            unset($new -> headers[$new -> headerNames[$nameLower]]);
        $new -> headers[$name] = $value;
        $new -> headerNames[$nameLower] = $name;

        return $new;
    }

    public function withAddedHeader($name, $value) {
        if($value === [])
            return $this;

        return $this -> withHeader(
            $name,
            array_merge($this -> getHeader($name), is_array($value) ? $value : [$value])
        );
    }

    public function withoutHeader($name) {
        $nameLower = strtolower($name);
        if(!isset($this -> headerNames[$nameLower]))
            return $this;

        $new = clone $this;
        unset(
            $new -> headers[$new -> headerNames[$nameLower]],
            $new -> headerNames[$nameLower]
        );

        return $new;
    }
}
