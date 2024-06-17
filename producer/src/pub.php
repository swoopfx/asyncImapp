<?php

require_once __DIR__.'../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// $channel->queue_declare('blue', false, false, false, false);
$channel->exchange_declare("pubsub", AMQPExchangeType::FANOUT);

$msg = new AMQPMessage(json_encode([
    "id"=>1,
    "name"=> "Segun Illumade",
    "age"=>34
]));
$channel->basic_publish($msg, 'pubsub', '');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();