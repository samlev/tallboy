<?php

declare(strict_types=1);

namespace Tallboy\Exception\Icons;

class InvalidIconException extends \RuntimeException
{
    public string $icon;
    public string $set;

    public static function make(string $icon, string $set): self
    {
        $exception = new self(sprintf('The icon [%s] does not exist in the [%s] icon set.', $icon, $set));
        $exception->icon = $icon;
        $exception->set = $set;

        return $exception;
    }
}
