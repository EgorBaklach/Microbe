<?php

use Framework\Emitters\SapiEmitter;
use Framework\Handlers\ErrorResponseHandler;
use Framework\Routers\LeagueRouter;
use Framework\Strategies\ApplicationStrategy;
use Framework\Templates\Plates;
use Magistrale\Caches\Phpfastcache;
use League\Container\Definition\{Definition, DefinitionAggregate};
use Phpfastcache\Drivers\Memcached\Config;

return new DefinitionAggregate([
    new Definition('dependencies', [
        'strategy' => ApplicationStrategy::class,
        'template' => Plates::class,
        'handler' => ErrorResponseHandler::class,
        'emitter' => SapiEmitter::class,
        'router' => LeagueRouter::class,
        'cache' => Phpfastcache::class
    ]),
    new Definition('cache', [
        'Memcached',
        Config::class
    ]),
    new Definition('template', [
        'templates',
        'php'
    ]),
    new Definition('databases', [
        'database' => [
            "host" => "localhost",
            "db" => "",
            "user" => "",
            "pass" => "",
            "charset" => ""
        ]
    ])
]);