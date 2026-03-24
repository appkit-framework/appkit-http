<?php

namespace AppKit\Http\Message;

use AppKit\Http\Message\Internal\HeadersTrait;
use AppKit\Http\Message\Internal\BodyTrait;

abstract class AbstractHttpRequest {
    use HeadersTrait;
    use BodyTrait;

    private $method;
    private $url;
    private $path;
    private $queryParams = [];
    private $attributes = [];

    function __construct($method, $url, $headers, $body) {
        $this -> setMethod($method);
        $this -> setUrl($url);
        $this -> setHeaders($headers);
        $this -> setBody($body);
    }

    // Method

    public function getMethod() {
        return $this -> method;
    }

    protected function setMethod($method) {
        $this -> method = strtoupper($method);
    }

    // URL

    public function getUrl() {
        return $this -> url;
    }

    protected function setUrl($url) {
        $this -> url = $url;
        $this -> parseUrl();
    }

    public function getPath() {
        return $this -> path;
    }

    protected function setPath($path) {
        $this -> path = $path;
        $this -> buildUrl();
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
        $this -> buildUrl();
    }

    private function parseUrl() {
        $parsedUrl = parse_url($this -> url);
        $this -> path = $parsedUrl['path'] ?? '';
        parse_str($parsedUrl['query'] ?? '', $this -> queryParams);
    }

    private function buildUrl() {
        $url = $this -> path;
        if(!empty($this -> queryParams))
            $url .= '?' . http_build_query($this -> queryParams);
        $this -> url = $url;
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
