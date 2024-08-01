<?php

use Tallboy\Support\Exception\Factory;
use Tallboy\Support\Exception\MakesExceptions;

it('generates a name from the class name', function () {
    expect(MakesExceptionsException::makeMessage())
        ->toBe('Makes Exceptions Exception');
});

it('creates a factory for exceptions', function () {
    $factory = MakesExceptionsException::factory();

    expect($factory)->toBeInstanceOf(Factory::class)
        ->toHaveProperty('exception', MakesExceptionsException::class)
        ->and($factory->message)->toBe('')
        ->and($factory->code)->toBe(0)
        ->and($factory->previous)->toBeNull();
});

it('passes parameters to exception factory', function () {
    $previous = new Exception();

    $factory = MakesExceptionsException::factory(
        message: 'test',
        code: 42,
        previous: $previous,
        foo: 'foo',
    );

    expect($factory)->toBeInstanceOf(Factory::class)
        ->toHaveProperty('exception', MakesExceptionsException::class)
        ->and($factory->message)->toBe('test')
        ->and($factory->code)->toBe(42)
        ->and($factory->previous)->toBe($previous)
        ->and($factory->foo)->toBe('foo');
});

it('makes exception', function () {
    $exception = MakesExceptionsException::make();

    expect($exception)->toBeInstanceOf(MakesExceptionsException::class)
        ->and($exception->getMessage())->toBe(MakesExceptionsException::makeMessage())
        ->and($exception->getCode())->toBe(0)
        ->and($exception->getPrevious())->toBeNull();
});

it('makes exception with parameters', function () {
    $previous = new Exception();

    $exception = MakesExceptionsException::make(
        message: 'test',
        code: 42,
        previous: $previous,
        foo: 'foo',
    );

    expect($exception)->toBeInstanceOf(MakesExceptionsException::class)
        ->and($exception->getMessage())->toBe('test')
        ->and($exception->getCode())->toBe(42)
        ->and($exception->getPrevious())->toBe($previous)
        ->and($exception->foo)->toBe('foo');
});

class MakesExceptionsException extends \Exception
{
    use MakesExceptions;

    public string $foo;
}
