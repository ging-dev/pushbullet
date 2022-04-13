<?php

declare(strict_types=1);

use Amp\Loop;
use function Amp\Websocket\Client\connect;
use Amp\Websocket\Client\Handshake;
use Amp\Websocket\Options;

require_once __DIR__.'/vendor/autoload.php';

// token: o.CMbHtSRxGpdVWihdoPl0aYYXHrDb2rY0
Loop::run(function () {
    $options = Options::createClientDefault()->withoutHeartbeat();
    $handshake = new Handshake('wss://stream.pushbullet.com/websocket/o.JrvbdlvAPioM8zftSDkWHLubeRmzs30p', $options);
    $conn = yield connect($handshake);

    while ($message = yield $conn->receive()) {
        /** @var string */
        $payload = yield $message->buffer();
        if (false !== $data = getNotificationMirrored($payload)) {
            echo $data['title'].': '.$data['body'].PHP_EOL;
        }
    }
});
