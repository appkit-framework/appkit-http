<?php

namespace AppKit\Http\Message\Internal;

trait HeadersTrait {
    private $headers = [];

    public function hasHeader($name) {
        return isset($this -> headers[$name]);
    }

    public function getHeader($name) {
        return $this -> headers[$name] ?? [];
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

        $this -> headers[$name] = $value;
    }

    protected function setHeaders($headers) {
        foreach($headers as $name => $value)
            $this -> setHeader($name, $value);
    }

    protected function addHeader($name, $value) {
        $this -> headers[$name][] = (string) $value;
    }

    protected function unsetHeader($name) {
        unset($this -> headers[$name]);
    }
}
