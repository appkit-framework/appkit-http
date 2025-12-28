<?php

namespace AppKit\Http\Middleware;

class HttpMiddlewarePipeline {
    private $handler;

    private $middlewares;

    function __construct($handler) {
        $this -> handler = $handler;

        $this -> middlewares = [];
    }

    public function addMiddleware($middleware) {
        $this -> middlewares[] = $middleware;

        return $this;
    }

    public function getMiddlewares() {
        return $this -> middlewares;
    }

    public function processRequest($request) {
        return $this -> call($request, 0);
    }

    private function call($request, $position) {
        if(!isset($this -> middlewares[$position]))
            return ($this -> handler)($request);

        return $this -> middlewares[$position] -> processRequest(
            $request,
            function($req) use($position) {
                return $this -> call($req, $position + 1);
            }
        );
    }
}
