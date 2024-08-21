<?php

declare(strict_types=1);

use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\ComponentSlot;
use Tallboy\Features\SupportView\ViewService;
use Tallboy\View\Component;

it('detects if something is a slot', function () {
    $service = new ViewService();

    expect($service->isSlot(new ComponentSlot('foo')))->toBeTrue()
        ->and($service->isSlot(new ComponentSlot()))->toBeTrue()
        ->and($service->isSlot(new ComponentAttributeBag()))->toBeFalse()
        ->and($service->isSlot(null))->toBeFalse()
        ->and($service->isSlot('foo'))->toBeFalse();
});

it('detects if something is a non-empty slot', function () {
    $service = new ViewService();

    expect($service->hasSlot(new ComponentSlot('foo')))->toBeTrue()
        ->and($service->hasSlot(new ComponentSlot()))->toBeFalse()
        ->and($service->hasSlot(new ComponentAttributeBag()))->toBeFalse()
        ->and($service->hasSlot(null))->toBeFalse()
        ->and($service->hasSlot('foo'))->toBeFalse();
});

it('provides a component attribute bag from something', function (mixed $slot) {
    $service = new ViewService();

    $bag = $service->attributes($slot);

    expect(get_class($bag))->toBe(ComponentAttributeBag::class);
})->with([
    'component' => fn () => new FooComponent(),
    'component slot' => fn () => new ComponentSlot(),
    'component attribute bag' => fn () => new ComponentAttributeBag(),
    'string' => 'foo',
    'int' => 1,
    'array' => ['foo' => 'bar'],
    'null' => null,
]);

it('does not create a new bag for components', function (Component $slot) {
    $service = new ViewService();

    $bag = $service->attributes($slot);

    expect($bag)->toBe($slot->attributes)
        ->and($bag->get('foo'))->toBe($slot->attributes->get('foo'));
})->with([
    'component' => fn () => new FooComponent(),
    'component with attributes' => fn () => new FooComponent(['foo' => 'bar']),
]);

it('does not create a new bag for component slots', function (ComponentSlot $slot) {
    $service = new ViewService();

    $bag = $service->attributes($slot);

    expect($bag)->toBe($slot->attributes)
        ->and($bag->get('foo'))->toBe($slot->attributes->get('foo'));
})->with([
    'component slot with content' => fn () => new ComponentSlot('foo'),
    'component slot with attributes' => fn () => new ComponentSlot('foo', ['foo' => 'bar']),
    'empty component slot' => fn () => new ComponentSlot(),
]);

it('does not create a new bag for for existing attribute bags', function (ComponentAttributeBag $slot) {
    $service = new ViewService();

    $bag = $service->attributes($slot);

    expect($bag)->toBe($slot)
        ->and($bag->get('foo'))->toBe($slot->get('foo'));
})->with([
    'component attribute bag with attributes' => fn () => new ComponentAttributeBag(['foo' => 'bar']),
    'empty component attribute bag' => fn () => new ComponentAttributeBag(),
]);

class FooComponent extends Component
{
    public function __construct(array $attrs = [])
    {
        $this->attributes = new ComponentAttributeBag($attrs);
    }

    public function render(): string
    {
        return 'foo';
    }
}
