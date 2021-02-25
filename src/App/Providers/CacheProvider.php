<?php namespace App\Providers;

use Contracts\Cache\RememberInterface;
use Framework\Providers\ProviderAbstract;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class CacheProvider extends ProviderAbstract implements BootableServiceProviderInterface
{
    private $dependencies;
    private $cache;

    protected $provides = [RememberInterface::class];

    public function boot()
    {
        $this->dependencies = $this->container()->get('dependencies');
        $this->cache = $this->container()->get('cache');
    }

    public function register()
    {
        $this->container()->add(RememberInterface::class, $this->dependencies['cache'])->addArguments($this->cache);
    }
}