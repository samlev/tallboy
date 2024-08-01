<?php

declare(strict_types=1);

namespace Tallboy\Exceptions\Icons;

use Tallboy\Exceptions\InvalidConfigurationException;

class InvalidIconSetException extends InvalidConfigurationException
{
    public string $set;

    public static function makeMessage(string $set = 'default'): string
    {
        return sprintf('The icon set [%s] cannot be found.', $set);
    }
}
