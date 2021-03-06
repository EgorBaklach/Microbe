<?php namespace Cli\Providers;

use Cli\Console\ConsoleInterface;
use Framework\Providers\ProviderAbstract;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ServiceProvider extends ProviderAbstract implements BootableServiceProviderInterface
{
    /** @var array */
    private $dependencies;

    protected $provides = [ConsoleInterface::class];

    public function boot()
    {
        $this->dependencies = $this->container()->get('dependencies');
    }

    public function register()
    {
        $this->container()->add(ConsoleInterface::class, $this->dependencies['console']);
    }
}