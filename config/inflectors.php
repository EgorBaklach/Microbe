<?php

use Contracts\Router\RouterInterface;
use Framework\Inflectors\{InflectorAggregate, RouteInflector};
use Infrastructure\Inflectors\ORMInflector;
use Molecule\ORMFactory;

return new InflectorAggregate([
    RouterInterface::class => RouteInflector::class,
    ORMFactory::class => ORMInflector::class
]);