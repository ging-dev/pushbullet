<?php

use Evenement\EventEmitterInterface;
use function Ratchet\Client\connect;
use Ratchet\RFC6455\Messaging\Message;

require_once __DIR__.'/vendor/autoload.php';

connect('wss://stream.pushbullet.com/websocket/o.CMbHtSRxGpdVWihdoPl0aYYXHrDb2rY0')->then(
    function (EventEmitterInterface $conn) {
        $conn->on('message', function (Message $message) {
            if (false !== $data = getNotificationMirrored((string) $message)) {
                echo $data['title'].': '.$data['body'].PHP_EOL;
            }
        });
    }, function (Throwable $e) {
        echo "Could not connect: {$e->getMessage()}\n";
    }
);
