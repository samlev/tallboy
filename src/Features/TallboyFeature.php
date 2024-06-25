<?php

namespace Tallboy\Features;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

abstract class TallboyFeature
{
    public function __construct(
        protected Application $app,
        protected Repository $config,
    ) {
        //
    }

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }

    /**
     * @return string[]
     */
    public function provides(): array
    {
        return [];
    }
}
