<?php

declare(strict_types=1);

use Tallboy\View\Component;

it('extracts public properties', function () {
    $reflected = new ReflectionMethod(ComponentWithPublicProperties::class, 'extractPublicPropertyNames');
    $reflected->setAccessible(true);

    expect($reflected->invoke(new ComponentWithPublicProperties()))->toBe([
        'foo',
        'bar',
        'baz',
        'attributes',
    ]);
});

it('extracts inherited public properties', function () {
    $reflected = new ReflectionMethod(ChildComponentWithPublicProperties::class, 'extractPublicPropertyNames');
    $reflected->setAccessible(true);

    expect($reflected->invoke(new ChildComponentWithPublicProperties()))->toBe([
        'quo',
        'qux',
        'foo',
        'bar',
        'baz',
        'attributes',
    ]);
});

it('extracts public properties that match constructor parameters', function () {
    $reflected = new ReflectionMethod(ComponentWithPublicPropertiesAndConstructor::class, 'extractPublicPropertyNames');
    $reflected->setAccessible(true);

    expect($reflected->invoke(new ComponentWithPublicPropertiesAndConstructor()))->toBe([
        'foo',
        'bar',
        'baz',
        'attributes',
    ]);
});

it('does not extract static or readonly public properties', function () {
    $reflected = new ReflectionMethod(ComponentWithReadonlyPublicProperties::class, 'extractPublicPropertyNames');
    $reflected->setAccessible(true);

    expect($reflected->invoke(new ComponentWithReadonlyPublicProperties()))->toBe([
        'foo',
        'attributes',
    ]);
});

it('resolves public properties', function () {
    $component = ComponentWithPublicProperties::resolve([
        'foo' => 'foo',
        'bar' => 42,
        'baz' => ['baz'],
    ]);

    expect($component->foo)->toBe('foo')
        ->and($component->bar)->toBe(42)
        ->and($component->baz)->toBe(['baz']);
});

it('resolves inherited public properties', function () {
    $component = ChildComponentWithPublicProperties::resolve([
        'foo' => 'foo',
        'bar' => 42,
        'baz' => ['baz'],
        'quo' => 'quo',
        'qux' => 99,
    ]);

    expect($component->foo)->toBe('foo')
        ->and($component->bar)->toBe(42)
        ->and($component->baz)->toBe(['baz'])
        ->and($component->quo)->toBe('quo')
        ->and($component->qux)->toBe(99);
});

it('resolves default values for public properties', function () {
    $component = ComponentWithPublicProperties::resolve([]);

    expect($component->foo)->toBe('oof')
        ->and($component->bar)->toBe(24)
        ->and($component->baz)->toBe([]);
});

it('does not resolve public properties that match constructor parameters', function () {
    $component = ComponentWithPublicPropertiesAndConstructor::resolve([
        'foo' => 'foo',
        'bar' => 42,
        'baz' => ['baz'],
    ]);

    expect($component->foo)->toBe('foo')
        ->and($component->bar)->toBe(42)
        ->and($component->baz)->toBe(['foo', 'bar']);
});

it('does not resolve static and readonly public properties', function () {
    $component = ComponentWithReadonlyPublicProperties::resolve([
        'foo' => 'foo',
        'bar' => 42,
        'baz' => ['baz'],
    ]);

    expect($component->foo)->toBe('foo')
        ->and($component->bar)->toBe(99)
        ->and($component::$baz)->toBe(['foo', 'bar']);
});

class ComponentWithPublicProperties extends Component
{
    public string $foo = 'oof';
    public int $bar = 24;
    public array $baz = [];

    public function render()
    {
        return view('tallboy::components.foo');
    }
}

class ChildComponentWithPublicProperties extends ComponentWithPublicProperties
{
    public string $quo;
    public int $qux;
}

class ComponentWithPublicPropertiesAndConstructor extends Component
{
    public string $foo;
    public int $bar;
    public array $baz;

    public function __construct(array $baz = [])
    {
        $this->baz = ['foo', 'bar'];
    }

    public function render()
    {
        return view('tallboy::components.foo');
    }
}

class ComponentWithReadonlyPublicProperties extends Component
{
    public string $foo;
    public readonly int $bar;
    public static array $baz = ['foo', 'bar'];

    public function __construct()
    {
        $this->bar = 99;
    }

    public function render()
    {
        return view('tallboy::components.foo');
    }
}
