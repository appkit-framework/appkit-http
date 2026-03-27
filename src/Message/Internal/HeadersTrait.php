<?php

namespace AppKit\Http\Message\Internal;

trait HeadersTrait {
    private $headers = [];
    private $headerNames = [];

    public function hasHeader($name) {
        return isset($this -> headerNames[ strtolower($name) ]);
    }

    public function getHeader($name) {
        $name = $this -> headerName[ strtolower($name) ] ?? null;
        return $name ? $this -> headers[$name] : [];
    }

    public function getHeaderLine($name) {
        return implode(', ', $this -> getHeader($name));
    }

    public function getHeaders() {
        return $this -> headers;
    }

    protected function setHeader($name, $value) {
        if($value === null || $value === []) {
            $this -> unsetHeader($name);
            return;
        }

        if(!is_array($value))
            $value = [ $value ];

        foreach($value as &$one)
            $one = (string) $one;

        $lower = strtolower($name);
        $name = $this -> headerNames[$lower] ?? $name;
        $this -> headers[$name] = $value;
        $this -> headerNames[$lower] = $name;

        return $this;
    }

    protected function setHeaders($headers) {
        foreach($headers as $name => $value)
            $this -> setHeader($name, $value);
        return $this;
    }

    protected function addHeader($name, $value) {
        $lower = strtolower($name);
        $name = $this -> headerNames[$lower] ?? $name;
        $this -> headers[$name][] = (string) $value;
        $this -> headerNames[$lower] = $name;

        return $this;
    }

    protected function unsetHeader($name) {
        $lower = strtolower($name);
        $name = $this -> headerNames[$lower] ?? null;

        if($name) {
            unset($this -> headerNames[$lower]);
            unset($this -> headers[$name]);
        }

        return $this;
    }
}
