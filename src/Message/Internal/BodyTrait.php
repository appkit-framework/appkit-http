<?php

namespace AppKit\Http\Message\Internal;

trait BodyTrait {
    private $body;
    private $bodyText;

    public function getBody() {
        return $this -> body;
    }

    public function getBodyText() {
        return $this -> bodyText;
    }

    protected function setBody($body) {
        $this -> body = $body;
    }

    protected function setBodyText($bodyText) {
        $this -> bodyText = $bodyText;
    }
}
