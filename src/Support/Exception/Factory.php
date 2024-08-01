<?php

declare(strict_types=1);

namespace Tallboy\Support\Exception;

use Illuminate\Support\Str;
use ReflectionClass;
use Throwable;

/**
 * @template TException of Throwable
 *
 * @property-read class-string<TException> $exception
 * @property-read string $message
 * @property-read int $code
 * @property-read ?Throwable $previous
 */
class Factory
{
    protected string $message = '';
    protected int $code = 0;
    protected ?Throwable $previous = null;
    /** @var array<string, mixed> */
    protected array $parameters = [];

    /**
     * @param class-string<TException> $exception
     */
    public function __construct(
        public readonly string $exception,
    ) {
        //
    }

    /**
     * @param class-string<TException> $exception
     * @return TException
     */
    public static function make(string $exception, mixed ...$params): Throwable
    {
        return (new self($exception))->withParameters(...$params)->toThrowable();
    }

    /**
     * @return $this<TException>
     */
    public function withMessage(string $message): self
    {
        $this->message = $this->message ?: $message;

        return $this;
    }

    /**
     * @return $this<TException>
     */
    public function withCode(int $code): self
    {
        $this->code = $this->code ?: $code;

        return $this;
    }

    /**
     * @return $this<TException>
     */
    public function withPrevious(Throwable $previous): self
    {
        $this->previous = $previous;

        return $this;
    }

    /**
     * @return $this<TException>
     */
    public function withParameter(string $name, mixed $value): self
    {
        if ($name === 'message' &&  is_string($value)) {
            return $this->withMessage($value);
        } elseif ($name === 'code' && is_int($value)) {
            return $this->withCode($value);
        } elseif ($name === 'previous' && $value instanceof Throwable) {
            return $this->withPrevious($value);
        } elseif ($this->isSettable($name)) {
            $this->parameters[$name] = $value;
        }

        return $this;
    }

    /**
     * @param mixed ...$params
     * @return $this<TException>
     */
    public function withParameters(mixed ...$params): self
    {
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $this->withParameter($key, $value);
            } elseif (is_array($value)) {
                $this->withParameters(...$value);
            }
        }

        return $this;
    }

    /**
     * @return TException
     */
    public function toThrowable(): Throwable
    {
        $concrete = new $this->exception($this->message, $this->code, $this->previous);

        foreach ($this->parameters as $key => $value) {
            if ($this->propertyExists($key)) {
                $concrete->{$key} = $value;
            } elseif ($this->setterExists($key)) {
                $concrete->{'set' . Str::camel($key)}($value);
            }
        }

        return $concrete;
    }

    /**
     * @throws TException
     */
    public function throw(): void
    {
        throw $this->toThrowable();
    }

    public function __get(string $property): mixed
    {
        return match ($property) {
            'exception', 'message', 'code', 'previous' => $this->$property,
            default => $this->parameters[$property] ?? null,
        };
    }

    /**
     * @throws \ReflectionException
     */
    protected function propertyExists(string $property): bool
    {
        $class = (new ReflectionClass($this->exception));

        if ($class->hasProperty($property)) {
            $reflection = $class->getProperty($property);

            return
                $reflection->isPublic()
                && !$reflection->isReadOnly()
                && !$reflection->isStatic();
        }

        return false;
    }

    protected function setterExists(string $property): bool
    {
        return method_exists($this->exception, 'set' . Str::camel($property));
    }

    protected function isSettable(string $property): bool
    {
        return $this->propertyExists($property) || $this->setterExists($property);
    }
}
