<?php

use Exception;
use Tallboy\Support\Exception\Factory;

it('sets standard properties', function () {
    $previous = new Exception();

    $factory = new Factory(Exception::class);

    $exception = $factory->withParameters(
        message: 'foo',
        code: 42,
        previous: $previous,
    )->toThrowable();

    expect($exception)->toBeInstanceOf(Exception::class)
        ->and($exception->getMessage())->toBe('foo')
        ->and($exception->getCode())->toBe(42)
        ->and($exception->getPrevious())->toBe($previous);
});

it('can set parameters for public writable properties', function () {
    $factory = new class (FactoryTestException::class) extends Factory {
        public function canSet(string $property): bool
        {
            return $this->isSettable($property);
        }
    };

    expect($factory->canSet('foo'))->toBeTrue()
        ->and($factory->canSet('bar'))->toBeFalse()
        ->and($factory->canSet('baz'))->toBeFalse();
});

it('can set parameters for non public properties with setters', function () {
    $factory = new class (FactoryTestException::class) extends Factory {
        public function canSet(string $property): bool
        {
            return $this->isSettable($property);
        }
    };

    expect($factory->canSet('quo'))->toBeTrue()
        ->and($factory->canSet('qux'))->toBeFalse();
});

it('sets writable public properties', function () {
    $previous = new Exception();

    $factory = new Factory(FactoryTestException::class);

    $exception = $factory->withParameters(
        message: 'test',
        code: 42,
        previous: $previous,
        foo: 'foo',
        bar: 'bar',
        baz: 'baz',
        quo: 'quo',
        qux: 'qux',
    )->toThrowable();

    expect($exception->all())
        ->toHaveKey('message', 'test')
        ->toHaveKey('code', 42)
        ->toHaveKey('previous', $previous)
        ->toHaveKey('foo', 'foo')
        ->toHaveKey('quo', 'quo')
        ->not->toHaveKey('bar', 'bar')
        ->not->toHaveKey('baz', 'baz')
        ->not->toHaveKey('qux', 'qux');
});

it('makes an exception', function () {
    $exception = Factory::make(Exception::class);

    expect($exception)->toBeInstanceOf(Exception::class)
        ->and($exception->getMessage())->toBe('')
        ->and($exception->getCode())->toBe(0)
        ->and($exception->getPrevious())->toBeNull();
});

it('makes an exception with standard parameters', function () {
    $previous = new Exception();

    $exception = Factory::make(
        Exception::class,
        message: 'foo',
        code: 42,
        previous: $previous,
    );

    expect($exception)->toBeInstanceOf(Exception::class)
        ->and($exception->getMessage())->toBe('foo')
        ->and($exception->getCode())->toBe(42)
        ->and($exception->getPrevious())->toBe($previous);
});

it('makes an exception with extra parameters', function () {
    $previous = new Exception();

    $exception = Factory::make(
        FactoryTestException::class,
        message: 'test',
        code: 42,
        previous: $previous,
        foo: 'foo',
        bar: 'bar',
        baz: 'baz',
        quo: 'quo',
        qux: 'qux',
    );

    expect($exception)->toBeInstanceOf(FactoryTestException::class)
        ->and($exception->all())
        ->toHaveKey('message', 'test')
        ->toHaveKey('code', 42)
        ->toHaveKey('previous', $previous)
        ->toHaveKey('foo', 'foo')
        ->toHaveKey('quo', 'quo')
        ->not->toHaveKey('bar', 'bar')
        ->not->toHaveKey('baz', 'baz')
        ->not->toHaveKey('qux', 'qux');
});

class FactoryTestException extends Exception
{
    public string $foo;
    public readonly string $bar;
    public static string $baz;
    protected string $quo;
    protected string $qux;

    public function setQuo(string $quo): void
    {
        $this->quo = $quo;
    }

    public function all(): array
    {
        return array_filter([
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'previous' => $this->getPrevious(),
            'foo' => $this->foo ?? null,
            'bar' => $this->bar ?? null,
            'baz' => self::$baz ?? null,
            'qux' => $this->qux ?? null,
            'quo' => $this->quo ?? null,
        ]);
    }
}
