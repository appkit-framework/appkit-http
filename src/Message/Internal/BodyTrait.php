<?php

namespace AppKit\Http\Message\Internal;

trait BodyTrait {
    private $body;
    private $bodyText;

    public function getBody() {
        return $this -> body;
    }

    public function hasBodyParam($name) {
        return isset($this -> body[$name]);
    }

    public function getBodyParam($name) {
        return $this -> body[$name] ?? null;
    }

    public function getBodyText() {
        return $this -> bodyText;
    }

    protected function setBody($body) {
        $this -> body = $body;
        return $this;
    }

    protected function setBodyParam($name, $value) {
        $this -> body[$name] = $value;
        return $this;
    }

    protected function setBodyText($bodyText) {
        $this -> bodyText = $bodyText;
        return $this;
    }
}
