<?php namespace Framework\Providers;

use Contracts\Provider\{ProviderAggregateInterface, ProviderInterface};
use League\Container\ContainerAwareTrait;
use League\Container\Exception\ContainerException;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use League\Container\ServiceProvider\ServiceProviderAggregateInterface;
use ReflectionClass;
use Traversable;

class ProviderAggregate implements ProviderAggregateInterface, ServiceProviderAggregateInterface
{
    use ContainerAwareTrait;

    /** @var ProviderInterface[] */
    private $providers;

    /** @var array */
    private $registered;

    public function __construct(array $providers)
    {
        foreach($providers as $provider)
        {
            $this->providers[] = $this->resolve($provider);
        }
    }

    public function resolve($provider): ProviderInterface
    {
        if(is_string($provider))
        {
            if(!class_exists($provider))
            {
                throw new ContainerException(sprintf('(%s) is not exist', $provider));
            }

            $provider = new ReflectionClass($provider);
        }

        if(!$provider->isSubclassOf(ProviderAbstract::class))
        {
            throw new ContainerException(sprintf('(%s) is not provider class', $provider));
        }

        return $provider->newInstance($this);
    }

    public function add($provider): ServiceProviderAggregateInterface
    {
        $this->providers[] = $this->resolve($provider);

        return $this;
    }

    public function provides(string $service): bool
    {
        foreach($this->getIterator() as $name => $provider)
        {
            if($provider->provides($service))
            {
                return true;
            }
        }

        return false;
    }

    public function register(string $service)
    {
        if (false === $this->provides($service))
        {
            throw new ContainerException(sprintf('(%s) is not provided by a service provider', $service));
        }

        foreach ($this->getIterator() as $provider)
        {
            if (in_array($provider->getIdentifier(), $this->registered, true))
            {
                continue;
            }

            if($provider instanceof BootableServiceProviderInterface)
            {
                $provider->boot();
            }

            if ($provider->provides($service))
            {
                $provider->register();
                $this->registered[] = $provider->getIdentifier();
            }
        }
    }

    public function getIterator(): Traversable
    {
        foreach($this->providers as $provider)
        {
            yield $provider;
        }
    }
}
