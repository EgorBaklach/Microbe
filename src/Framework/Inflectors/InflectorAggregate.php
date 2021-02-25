<?php namespace Framework\Inflectors;

use Contracts\Inflector\InflectorAggregateInterface;
use League\Container\ContainerAwareTrait;
use League\Container\Exception\ContainerException;
use League\Container\Inflector\Inflector;
use League\Container\Inflector\InflectorAggregateInterface as InflectorAggregateInterfaceLeague;
use ReflectionClass;
use Traversable;

class InflectorAggregate implements InflectorAggregateInterface, InflectorAggregateInterfaceLeague
{
    use ContainerAwareTrait;

    /** @var Inflector[] */
    private $inflectors = [];

    public function __construct(array $inflectors)
    {
        foreach($inflectors as $type => $inflector)
        {
            $this->inflectors[] = $this->resolve($type, $inflector);
        }
    }

    public function resolve(string $type, $inflector): Inflector
    {
        if(is_string($inflector))
        {
            if(!class_exists($inflector))
            {
                throw new ContainerException(sprintf('(%s) is not exist', $inflector));
            }

            $inflector = new ReflectionClass($inflector);
        }

        if(!$inflector->hasMethod('__invoke'))
        {
            throw new ContainerException(sprintf('(%s) is not invokable class', $inflector));
        }

        return new Inflector($type, $inflector->newInstance($this));
    }

    public function add(string $type, callable $callback = null) : Inflector
    {
        return $this->inflectors[] = $this->resolve($type, $callback);
    }

    public function getIterator(): Traversable
    {
        foreach($this->inflectors as $inflector)
        {
            yield $inflector;
        }
    }

    public function inflect($object)
    {
        foreach ($this->getIterator() as $inflector)
        {
            $type = $inflector->getType();

            if (!$object instanceof $type) continue;

            $inflector->setLeagueContainer($this->getLeagueContainer());
            $inflector->inflect($object);
        }

        return $object;
    }
}
