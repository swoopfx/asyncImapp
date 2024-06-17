<?php

require_once __DIR__.'../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;



$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('blue', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    sleep(10);
    echo ' [x] Received ', $msg->body, "\n";
    // echo json_decode($msg->body);
  };

  $channel->basic_qos(0, 1, false);

//   $channel->basic_ack(1);
  
  $channel->basic_consume('blue', '', false, true, false, false, $callback);
  
  try {
      $channel->consume();
  } catch (\Throwable $exception) {
      echo $exception->getMessage();
  }