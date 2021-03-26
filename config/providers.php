<?php

use App\Providers\CacheProvider;
use App\Providers\DBProvider;
use Cli\Providers\ServiceProvider as CliServiceProvider;
use Framework\Providers\ProviderAggregate;
use Framework\Providers\ServiceProvider;

return new ProviderAggregate([
    CliServiceProvider::class,
    ServiceProvider::class,
    CacheProvider::class,
    DBProvider::class
]);