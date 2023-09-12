<?php namespace Cli\Commands;

use Contracts\Console\CommandInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand extends Command implements CommandInterface
{
    protected static $defaultName = 'hello:world';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Outputs "Hello World"');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello World'); return Command::SUCCESS;
    }

    public function setContainer(ContainerInterface $container)
    {

    }

    public function construct()
    {

    }
}
