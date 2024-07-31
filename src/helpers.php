<?php

declare(strict_types=1);

if (! function_exists('attrs')) {
    function attrs(mixed $slot): \Illuminate\View\ComponentAttributeBag
    {
        return app('tallboy-view')->attributes($slot);
    }
}

if (! function_exists('isSlot')) {
    function isSlot(mixed $slot): bool
    {
        return app('tallboy-view')->isSlot($slot);
    }
}

if (! function_exists('hasSlot')) {
    function hasSlot(mixed $slot): bool
    {
        return app('tallboy-view')->hasSlot($slot);
    }
}

if (! function_exists('icon')) {
    /**
     * @param array<array-key, mixed> $attributes
     */
    function icon(string $name, string $class = '', array $attributes = []): \BladeUI\Icons\Svg
    {
        return app('tallboy-icons')->icon($name, $class, $attributes);
    }
}
