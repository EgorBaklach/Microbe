<?php namespace App\Providers;

use Framework\Providers\ProviderAbstract;
use Infrastructure\Databases\ORMDatabase;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class DBProvider extends ProviderAbstract implements BootableServiceProviderInterface
{
    /** @var array */
    private $accesses;

    protected $provides = [ORMDatabase::class];

    public function boot()
    {
        $this->accesses = $this->container()->get('databases');
    }

    public function register()
    {
        $this->container()->add(ORMDatabase::class)->addArgument($this->accesses['database']);
    }
}