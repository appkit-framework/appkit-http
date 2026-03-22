<?php

namespace AppKit\Http\Message;

class HttpRedirect extends AbstractHttpResponseException {
    function __construct(
        $location,
        $statusCode = 302,
        $headers = [],
        $previous = null
    ) {
        parent::__construct(
            $statusCode,
            "Redirect to $location",
            [ 'Location' => $location ] + $headers,
            $previous
        );
    }

    public function getLocation() {
        return $this -> getHeaderLine('Location');
    }
}
