<?php namespace App\Providers;

use Framework\Providers\ProviderAbstract;
use Magistrale\Databases\ORMDatabase;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class DBProvider extends ProviderAbstract implements BootableServiceProviderInterface
{
    /** @var array */
    private $accesses;

    protected $provides = [ORMDatabase::class];

    public function boot(): void
    {
        $this->accesses = $this->container()->get('databases');
    }

    public function register(): void
    {
        $this->container()->add(ORMDatabase::class)->addArguments($this->accesses['database']);
    }
}