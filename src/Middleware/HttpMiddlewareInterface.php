<?php

namespace AppKit\Http\Middleware;

interface HttpMiddlewareInterface {
    public function processRequest($request, $next);
}
