<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @Consumer(exchange="hyperf", routingKey="hyperf", queue="hyperf", name ="HelloConsumer", nums=1)
 */
class HelloConsumer extends ConsumerMessage
{
    protected $maxConsumption = 0;

    public function consumeMessage($data, AMQPMessage $message): string
    {

        foreach ($data as $key => $value) {
            print_r('Hello AMQP, I\'m ' . $value);
        }
//        throw new RuntimeException('消息消费错误');
        return Result::ACK;
//        return Result::NACK;
    }
}
