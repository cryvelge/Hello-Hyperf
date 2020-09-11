<?php

declare(strict_types=1);

namespace App\Command\Hello;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @Command
 */
class HelloCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $description = 'Demo Command of Hyperf';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('command:hello');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription($this->description);
    }

    public function handle()
    {
        //通过参数获取
//        $name = $this->input->getArgument('name') ?? 'Hyper';
//        $times = $this->input->getArgument('times') ?? 1;
//        $extra = $this->input->getArgument('extra') ?? '';

        //通过选项获取
        $name = $this->input->getOption('name') ?? 'Hyper';
        $times = $this->input->getOption('times') ?? 1;
        $extra = $this->input->getOption('extra') ?? '';
        if ($times > 0)  {
            for ($i = 1; $i <= $times; $i ++) {
                $this->line('Hello ' . $name . $extra, 'info');
            }
        }
        return;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name you want to say hello',],
            ['times', InputArgument::OPTIONAL, 'how many times you want to say',],
            ['extra', InputArgument::OPTIONAL, 'some extra msg append the words',],
        ];
    }

    protected function getOptions()
    {
        return [
            ['name', null, InputOption::VALUE_OPTIONAL, 'The name you want to say hello',],
            ['times', null, InputOption::VALUE_OPTIONAL, 'how many times you want to say',],
            ['extra', null, InputOption::VALUE_OPTIONAL, 'some extra msg append the words',],
        ];
    }
}
