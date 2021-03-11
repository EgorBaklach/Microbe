<?php namespace Framework\Providers;

use Contracts\Emitter\EmitterInterface;
use Contracts\Router\RouterInterface;
use Contracts\Template\TemplateInterface;
use Laminas\Diactoros\ResponseFactory;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use League\Route\Strategy\StrategyInterface;
use Framework\Handlers\ErrorHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class ServiceProvider extends ProviderAbstract implements BootableServiceProviderInterface
{
    private $dependencies;
    private $template;

    protected $provides = [
        TemplateInterface::class,
        StrategyInterface::class,
        RouterInterface::class,
        EmitterInterface::class
    ];

    public function boot()
    {
        $this->dependencies = $this->container()->get('dependencies');
        $this->template = $this->container()->get('template');
    }

    public function register()
    {
        $this->container()
            ->add(ResponseFactoryInterface::class, ResponseFactory::class);

        $this->container()
            ->add(TemplateInterface::class, $this->dependencies['template'])
            ->addMethodCall('init', $this->template);

        $this->container()
            ->add(ErrorHandlerInterface::class, $this->dependencies['handler'])
            ->addArguments([ResponseFactoryInterface::class, TemplateInterface::class]);

        $this->container()
            ->add(StrategyInterface::class, $this->dependencies['strategy'])
            ->addMethodCall('setContainer', [$this->container()]);

        $this->container()
            ->add(RouterInterface::class, $this->dependencies['router'])
            ->addMethodCall('setStrategy', [StrategyInterface::class]);

        $this->container()
            ->add(EmitterInterface::class, $this->dependencies['emitter'])
            ->addMethodCall('emit', [RouterInterface::class]);
    }
}