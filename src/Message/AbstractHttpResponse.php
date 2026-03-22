<?php

namespace AppKit\Http\Message;

use AppKit\Http\Message\Internal\HeadersTrait;
use AppKit\Http\Message\Internal\BodyTrait;
use AppKit\Http\Message\Internal\ReasonTrait;

abstract class AbstractHttpResponse {
    use HeadersTrait;
    use BodyTrait;
    use ReasonTrait;

    private $status;

    function __construct(
        $status = 200,
        $headers = [],
        $body = ''
    ) {
        $this -> setStatus($status);
        foreach($headers as $name => $value)
            $this -> setHeader($name, $value);
        $this -> setBody($body);
    }

    // Status

    public function getStatus() {
        return $this -> status;
    }

    protected function setStatus($status) {
        $this -> status = intval($status);
    }

    // Parsed body

    // Cookies
}
