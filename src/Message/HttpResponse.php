<?php

/* Based on ReactPHP code, released under the MIT License
 * Original copyright (c) 2012 Christian Luck, Cees-Jan Kiewiet, Jan Sorgalla, Chris Boden, Igor Wiedler
 */

namespace AppKit\Http\Message;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use React\Http\Io\AbstractMessage;
use React\Http\Io\BufferedBody;
use React\Http\Io\HttpBodyStream;
use React\Stream\ReadableStreamInterface;
use InvalidArgumentException;
use ReflectionClass;

class HttpResponse extends AbstractMessage implements ResponseInterface, StatusCodeInterface {
    private static $phrasesInitialized = false;
    private static $phrasesMap = [
        200 => 'OK',
        203 => 'Non-Authoritative Information',
        207 => 'Multi-Status',
        226 => 'IM Used',
        414 => 'URI Too Large',
        418 => 'I\'m a teapot',
        505 => 'HTTP Version Not Supported'
    ];
    private $statusCode;
    private $reasonPhrase;

    public function __construct(
        $status = self::STATUS_OK,
        $headers = [],
        $body = '',
        $version = '1.1',
        $reason = null
    ) {
        if(is_string($body))
            $body = new BufferedBody($body);
        else if($body instanceof ReadableStreamInterface && !$body instanceof StreamInterface)
            $body = new HttpBodyStream($body, null);
        else if(!$body instanceof StreamInterface)
            throw new InvalidArgumentException('Invalid response body given');

        parent::__construct($version, $headers, $body);

        $this -> statusCode = (int) $status;
        $this -> reasonPhrase = ($reason !== '' && $reason !== null)
            ? (string) $reason
            : self::getReasonPhraseForStatusCode($status);
    }

    public function getStatusCode() {
        return $this -> statusCode;
    }

    public function withStatus($code, $reasonPhrase = '') {
        if((string) $reasonPhrase === '')
            $reasonPhrase = self::getReasonPhraseForStatusCode($code);

        if($this -> statusCode === (int) $code && $this -> reasonPhrase === (string) $reasonPhrase)
            return $this;

        $response = clone $this;
        $response -> statusCode = (int) $code;
        $response -> reasonPhrase = (string) $reasonPhrase;

        return $response;
    }

    public function getReasonPhrase() {
        return $this -> reasonPhrase;
    }

    private static function getReasonPhraseForStatusCode($code) {
        if(!self::$phrasesInitialized) {
            self::$phrasesInitialized = true;

            $ref = new ReflectionClass(__CLASS__);
            foreach($ref -> getConstants() as $name => $value)
                if(!isset(self::$phrasesMap[$value]) && strpos($name, 'STATUS_') === 0)
                    self::$phrasesMap[$value] = ucwords(strtolower(str_replace('_', ' ', substr($name, 7))));
        }

        return self::$phrasesMap[$code] ?? '';
    }
}
