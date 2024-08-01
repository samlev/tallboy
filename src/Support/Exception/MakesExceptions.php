<?php

declare(strict_types=1);

namespace Tallboy\Support\Exception;

use Illuminate\Support\Str;
use Throwable;

/**
 * @mixin Throwable
 */
trait MakesExceptions
{
    public static function makeMessage(): string
    {
        return Str::headline(class_basename(static::class));
    }

    /**
     * @param mixed ...$params
     * @return static
     */
    public static function make(mixed ...$params): static
    {
        $params['message'] ??= static::makeMessage(...$params);
        $params['code'] ??= 0;
        $params['previous'] ??= null;

        return static::factory(...$params)->toThrowable();
    }

    /**
     * @param mixed ...$params
     * @return Factory<static>
     */
    public static function factory(mixed ...$params): Factory
    {
        /** @var Factory<static> $factory */
        $factory = new Factory(static::class);

        return $factory->withParameters(...$params);
    }
}
