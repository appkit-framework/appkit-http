<?php

namespace AppKit\Http\Message;

use AppKit\Http\Message\Internal\HeadersTrait;
use AppKit\Http\Message\Internal\ReasonTrait;

use Exception;

abstract class AbstractHttpResponseException extends Exception {
    use HeadersTrait;
    use ReasonTrait;

    function __construct($status, $message = null, $headers = [], $previous = null) {
        parent::__construct(
            $message ?? self::getReasonForStatus($status) ?? 'Unknown Status',
            $status,
            $previous
        );

        foreach($headers as $name => $value)
            $this -> setHeader($name, $value);
    }

    public function getStatus() {
        return $this -> code;
    }
}
