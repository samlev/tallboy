<?php

declare(strict_types=1);

namespace Tallboy;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class TallboyServiceProvider extends ServiceProvider
{

    protected function registerTallboyIcons(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('tallboy', []);

            $factory->add('heroicons', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

    }
}
