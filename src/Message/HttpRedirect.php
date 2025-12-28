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

    public function getLocation() {
        return $this -> getHeaderLine('Location');
    }

    public function withLocation($location) {
        return $this -> withHeader('Location', $location);
    }
}
