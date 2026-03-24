<?php

namespace AppKit\Http\Message;

abstract class AbstractHttpRedirect extends AbstractHttpResponseException {
    function __construct($response, $previous = null) {
        parent::__construct(
            $response,
            'Redirect to ' . $response -> getHeaderLine('Location'),
            $previous
        );
    }

    public function getLocation() {
        return $this -> getResponse() -> getHeaderLine('Location');
    }
}
