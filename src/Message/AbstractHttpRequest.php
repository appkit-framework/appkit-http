<?php

namespace AppKit\Http\Message;

use AppKit\Http\Message\Internal\HeadersTrait;
use AppKit\Http\Message\Internal\BodyTrait;

abstract class AbstractHttpRequest {
    use HeadersTrait;
    use BodyTrait;

    private $method;
    private $target;
    private $path;
    private $queryParams = [];
    private $attributes = [];

    // Method

    public function getMethod() {
        return $this -> method;
    }

    protected function setMethod($method) {
        $this -> method = strtoupper($method);
        return $this;
    }

    // Target

    public function getTarget() {
        return $this -> target;
    }

    protected function setTarget($target) {
        $this -> target = $target;
        $this -> parseTarget();
        return $this;
    }

    public function getPath() {
        return $this -> path;
    }

    protected function setPath($path) {
        $this -> path = $path;
        $this -> buildTarget();
        return $this;
    }

    public function hasQueryParam($name) {
        return isset($this -> queryParams[$name]);
    }

    public function getQueryParam($name) {
        return $this -> queryParams[$name] ?? null;
    }

    public function getQueryParams() {
        return $this -> queryParams;
    }

    protected function setQueryParam($name, $value) {
        $this -> queryParams[$name] = (string) $value;
        $this -> buildTarget();
        return $this;
    }

    protected function setQueryParams($queryParams) {
        foreach($queryParams as $name => $value)
            $this -> setQueryParam($name, $value);
        return $this;
    }

    private function parseTarget() {
        $parsedTarget = parse_url($this -> target);
        $this -> path = $parsedTarget['path'] ?? '';
        parse_str($parsedTarget['query'] ?? '', $this -> queryParams);
    }

    private function buildTarget() {
        $target = $this -> path;
        if(!empty($this -> queryParams))
            $target .= '?' . http_build_query($this -> queryParams);
        $this -> target = $target;
    }

    // Attributes

    public function hasAttribute($name) {
        return isset($this -> attributes[$name]);
    }

    public function getAttribute($name) {
        return $this -> attributes[$name] ?? null;
    }

    public function setAttribute($name, $value) {
        $this -> attributes[$name] = $value;
        return $this;
    }
}
