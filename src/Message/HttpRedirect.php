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
            headers: [ 'Location' => $location ] + $headers,
            previous: $previous
        );
    }

    public function getMessage() {
        return 'Redirect to ' . $this -> getLocation();
    }

    public function getLocation() {
        return $this -> getHeaderLine('Location');
    }
}
