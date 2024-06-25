<?php

declare(strict_types=1);

namespace Tallboy\Exceptions\Icons;

use Tallboy\Exceptions\InvalidConfigurationException;

class InvalidIconSetException extends InvalidConfigurationException
{
    public string $set;

    public static function make(string $set): self
    {
        $exception = new self(sprintf('The icon set [%s] cannot be found.', $set));
        $exception->set = $set;

        return $exception;
    }
}
