<?php

use App\Providers\CacheProvider;
use App\Providers\DBProvider;
use Framework\Providers\ProviderAggregate;
use Framework\Providers\ServiceProvider;

return new ProviderAggregate([
    ServiceProvider::class,
    CacheProvider::class,
    DBProvider::class
]);