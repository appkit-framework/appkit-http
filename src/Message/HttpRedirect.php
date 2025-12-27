<?php

namespace AppKit\Http\Message;

class HttpRedirect extends HttpResponseException {
    function __construct(
        $location,
        $status = 302,
        $headers = [],
        $previous = null
    ) {
        parent::__construct(
            $status,
            "Redirect to $location",
            [ 'Location' => $location ] + $headers,
            $previous
        );
    }

    public function getLocation() {
        return $this -> getHeader('Location');
    }
}
