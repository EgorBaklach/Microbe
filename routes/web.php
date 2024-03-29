<?php

use App\Controllers\Home;
use App\Middlewares\{CredentialsMiddleware, ProfilerMiddleware};
use Contracts\Router\RouterInterface;
use Psr\Container\ContainerInterface;

/** @var RouterInterface $router */
/** @var ContainerInterface $container */

$router->middleware($container->get(CredentialsMiddleware::class));
$router->middleware($container->get(ProfilerMiddleware::class));

$router->map('GET', '/', Home::class);
