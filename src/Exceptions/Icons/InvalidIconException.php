<?php

declare(strict_types=1);

namespace Tallboy\Exceptions\Icons;

use Tallboy\Support\Exception\MakesExceptions;

class InvalidIconException extends \RuntimeException
{
    use MakesExceptions;

    public string $icon;
    public string $set;

    public static function makeMessage(string $icon = 'unknown', string $set = 'default'): string
    {
        return sprintf('The icon [%s] does not exist in the [%s] icon set.', $icon, $set);
    }
}
