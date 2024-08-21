<?php

declare(strict_types=1);

namespace Tallboy\View;

use Illuminate\Container\Container;
use Illuminate\View\Component as BaseComponent;
use ReflectionClass;
use ReflectionProperty;

abstract class Component extends BaseComponent
{
    /**
     * The cache of public parameters, keyed by class.
     *
     * @var array<class-string, array<int, string>>
     */
    protected static array $propertyNameCache = [];

    /**
     * Resolve the component instance with the given data.
     *
     * @param array<string, mixed> $data
     * @return static
     */
    public static function resolve($data): static
    {
        return tap(Container::getInstance()->make(static::class, $data), function ($instance) use ($data) {
            $dataKeys = array_diff(array_keys($data), static::extractConstructorParameters());

            foreach (static::extractPublicPropertyNames() as $parameter) {
                if (in_array($parameter, $dataKeys)) {
                    $instance->{$parameter} = $data[$parameter];
                }
            }
        });
    }

    /**
     * @return string[]
     */
    protected static function extractPublicPropertyNames(): array
    {
        static::$propertyNameCache[static::class] ??= collect(
            (new ReflectionClass(static::class))->getProperties(ReflectionProperty::IS_PUBLIC)
        )->reject(fn (ReflectionProperty $property) => $property->isStatic())
            ->reject(fn (ReflectionProperty $property) => $property->isReadOnly())
            ->map->getName()
            ->reject(fn (string $name) => in_array($name, ['componentName']))
            ->values()
            ->all();

        return static::$propertyNameCache[static::class];
    }

    /**
     * Get the cached set of anonymous component constructor parameter names to exclude.
     *
     * @return string[]
     */
    public static function ignoredParameterNames(): array
    {
        static::$ignoredParameterNames[static::class] ??= array_unique(array_merge(
            static::extractPublicPropertyNames(),
            static::extractConstructorParameters(),
        ));

        return static::$ignoredParameterNames[static::class];
    }
}
