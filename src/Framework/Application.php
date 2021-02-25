<?php namespace Framework;

use Contracts\Emitter\EmitterInterface;
use League\Container\Container;
use League\Container\Definition\DefinitionAggregateInterface;
use League\Container\Inflector\InflectorAggregateInterface;
use League\Container\ReflectionContainer;
use League\Container\ServiceProvider\ServiceProviderAggregateInterface;

class Application
{
    /** @var Container */
    private $container;

    public function __construct(DefinitionAggregateInterface $definitions, InflectorAggregateInterface $inflectors, ServiceProviderAggregateInterface $providers)
    {
        $this->container = new Container($definitions, $providers, $inflectors);
    }

    public static function make(array $config): self
    {
        return new self(...$config);
    }

    public function run()
    {
        $this->container->delegate(new ReflectionContainer)->get(EmitterInterface::class);
    }
}
