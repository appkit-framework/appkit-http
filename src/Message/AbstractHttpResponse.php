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

    function __construct($status, $headers, $body) {
        $this -> setStatus($status);
        $this -> setHeaders($headers);
        $this -> setBody($body);
    }

    // Status

    public function getStatus() {
        return $this -> status;
    }

    protected function setStatus($status) {
        $this -> status = intval($status);
    }
}
