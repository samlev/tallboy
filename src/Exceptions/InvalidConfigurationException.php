<?php

declare(strict_types=1);

namespace Tallboy\Exceptions;

use RuntimeException;
use Tallboy\Support\Exception\MakesExceptions;

class InvalidConfigurationException extends RuntimeException
{
    use MakesExceptions;
}
