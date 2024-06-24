<?php

declare(strict_types=1);

use BladeUI\Icons\Svg;
use Tallboy\Concerns\Icons\IconService;

if (! function_exists('icon')) {
    /**
     * @param string $name
     * @param string $class
     * @param array<array-key, mixed> $attributes
     * @return Svg
     */
    function icon(string $name, string $class = '', array $attributes = []): Svg
    {
        return app(IconService::class)->icon($name, $class, $attributes);
    }
}
