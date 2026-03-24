<?php

namespace AppKit\Http\Message;

abstract class AbstractHttpError extends AbstractHttpResponseException {
    function __construct($response, $message = null, $previous = null) {
        parent::__construct(
            $response,
            $message ?? $response -> getReason(),
            $previous
        );
    }
}
