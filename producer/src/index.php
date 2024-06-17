<?php

require_once __DIR__.'../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('blue', false, false, false, false);

$msg = new AMQPMessage(json_encode([
    "id"=>1,
    "name"=> "Segun Illumade",
    "age"=>34
]));
$channel->basic_publish($msg, '', 'blue');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();