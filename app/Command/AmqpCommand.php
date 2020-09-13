<?php

declare(strict_types=1);

namespace App\Command;

use App\Amqp\Producer\HelloProducer;
use App\Services\UserService;
use Hyperf\Amqp\Producer;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Coroutine;
use Psr\Container\ContainerInterface;

/**
 * @Command
 */
class AmqpCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $name = 'amqp:command';

    /**
     * @Inject()
     * @var Producer
     */
    protected $producer;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct($this->name);
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('command of test amqp');
    }

    public function handle()
    {
        $user = make(UserService::class)->get();
        //@doc 这里遇到一个问题 执行命令的时候报错说不在协程内，但是实际上消息却消费掉了,不知道为什么
        $data = $this->getQueueData($user);
        $this->produceMsg($data);
        $this->line('Hello AMQP!', 'info');
    }

    private function getQueueData($data)
    {
        return [
            'name' => $data,
        ];
    }

    private function produceMsg($data)
    {
        if (!Coroutine::inCoroutine()) {
            $this->line('--不在协程内--', 'info');
            Coroutine::create(function () use ($data) {
                $msg = new HelloProducer($data);
                $this->producer->produce($msg);
            });
        } else {
            $msg = new HelloProducer($data);
            $this->producer->produce($msg);
        }
    }
}
