<?php

namespace AppKit\Http\Exception;

class HttpRedirect extends HttpError {
    function __construct(
        $location,
        $status = 302,
        $previous = null,
        $headers = []
    ) {
        parent::__construct(
            $status,
            "Redirect to $location",
            $previous,
            [ 'Location' => $location ] + $headers
        );
    }

    public function getLocation() {
        return $this -> getHeader('Location');
    }
}
