<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest', '/');
$channel = $connection->channel();

for ($i = 0; $i < 10; $i++) {
    $headers = new AMQPTable();
    $headers->set('sample', 'value');
    $headers->set('type', 'report');

    $message = new AMQPMessage("Email {$i}");
    $message->set('application_headers', $headers);

    $channel->basic_publish($message, 'notifications', 'email');
}

$channel->close();
$connection->close();