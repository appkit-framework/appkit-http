<?php

namespace AppKit\Http\Exception;

use AppKit\Http\Exception\HttpError;

class HttpRedirect extends HttpError {
    function __construct(
        $location,
        $status = 302,
        $previous = null
    ) {
        parent::__construct(
            $status,
            "Redirect to $location",
            $previous,
            [ 'Location' => $location ]
        );
    }

    public function getLocation() {
        return $this -> getHeader('Location');
    }

    public function chainWithLocation($location) {
        return new static(
            $location,
            $this -> getCode(),
            $this
        );
    }
}
