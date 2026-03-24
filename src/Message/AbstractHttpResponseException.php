<?php

namespace AppKit\Http\Message;

use Exception;

abstract class AbstractHttpResponseException extends Exception {
    private $response;

    function __construct($response, $message, $previous = null) {
        parent::__construct(
            $message,
            $response -> getStatus(),
            $previous
        );
        $this -> response = $response;
    }

    public function getResponse() {
        return $this -> response;
    }
}
