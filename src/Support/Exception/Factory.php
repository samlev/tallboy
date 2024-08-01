<?php

declare(strict_types=1);

namespace Tallboy\Support\Exception;

use Throwable;

/**
 * @template TException of Throwable
 *
 * @property-read class-string<TException> $exception
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
     * @return self<TException>
     */
    public static function make(
        string $exception,
        mixed ...$params,
    ): self {
        return (new self($exception))->withParameters(...$params);
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
        }

        $this->parameters[$name] = $value;

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
            if (property_exists($concrete, $key)) {
                $concrete->{$key} = $value;
            } elseif (method_exists($concrete, 'set' . ucfirst($key))) {
                $concrete->{'set' . ucfirst($key)}($value);
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
}
