<?php

namespace AppKit\Http\Message\Internal;

trait BodyTrait {
    private $body;

    public function getBody() {
        return $this -> body;
    }

    protected function setBody($body) {
        $this -> body = $body;
    }
}
