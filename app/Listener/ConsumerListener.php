<?php

declare(strict_types=1);

namespace App\Listener;

use Hyperf\Amqp\Event\FailToConsume;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @Listener
 */
class ConsumerListener implements ListenerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get(LoggerFactory::class)->get('CONSUMER');
    }

    public function listen(): array
    {
        return [
            FailToConsume::class,
        ];
    }

    /**
     * 监听消费者异常
     *
     * @param FailToConsume $event
     *
     * @author  祝海亮 <hlzhu@suntekcorps.com>
     * @date    2020/9/3 8:53
     */
    public function process($event)
    {
        $this->logger->error(
            sprintf(
                'File:%s|Queue:%s|Message:%s',
                get_class($event->getMessage()),
                $event->getMessage()->getQueue(),
                $event->getThrowable()->getMessage()
            )
        );
    }
}
