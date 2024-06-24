<?php

declare(strict_types=1);

use Tallboy\Concerns\Icons\IconService;
use Tallboy\Concerns\Icons\IconSet;
use Tallboy\Exception\Icons\InvalidIconSetException;
use Tallboy\Exception\Icons\InvalidIconException;

it('can register enabled icon sets', function () {
    $service = new IconService();

    expect($service->hasIconSet('foo'))->toBeFalse();
    $service->registerIconSet(new FooIconSet());
    expect($service->hasIconSet('foo'))->toBeTrue();
});

it('cannot register disabled icon sets', function () {
    $service = new IconService();

    expect($service->hasIconSet('bar'))->toBeFalse();
    $service->registerIconSet(new BarIconSet());
    expect($service->hasIconSet('bar'))->toBeFalse();
});

it('does not automatically use icon sets', function () {
    $service = new IconService();

    expect($service->hasIconSet('foo'))->toBeFalse()
        ->and($service->getIconSet())->toBeEmpty()
        ->and($service->getIcons())->toBeEmpty();

    $service->registerIconSet(new FooIconSet());

    expect($service->hasIconSet('foo'))->toBeTrue()
        ->and($service->getIconSet())->toBeEmpty()
        ->and($service->getIcons())->toBeEmpty();
});

it('can use registered icon sets', function () {
    $service = (new IconService())->registerIconSet(new FooIconSet());

    expect($service->getIconSet())->toBeEmpty()
        ->and($service->getIcons())->toBeEmpty();

    $service->setIconSet('foo');

    expect($service->getIconSet())->toBe('foo')
        ->and($service->getIcons())->not->toBeEmpty();
});

it('cannot use un-registered icon sets', function () {
    $service = (new IconService())->registerIconSet(new FooIconSet());

    expect($service->getIconSet())->toBeEmpty()
        ->and($service->getIcons())->toBeEmpty()
        ->and(fn () => $service->setIconSet('bar'))
        ->toThrow(InvalidIconSetException::class)
        ->and($service->getIconSet())->toBeEmpty()
        ->and($service->getIcons())->toBeEmpty();
});

it('uses defined icons', function () {
    $set = new FooIconSet();
    $service = (new IconService())
        ->registerIconSet($set)
        ->setIconSet($set->name());

    expect($service->getIcons())->toHaveKey('alert', 'foo-other-alert');
});

it('automatically fills undefined icons', function () {
    $set = new FooIconSet();
    $service = (new IconService())
        ->registerIconSet($set)
        ->setIconSet($set->name());

    expect($service->getIcons())
        ->toHaveKey('info', 'foo-info')
        ->toHaveKey('error', 'foo-error')
        ->toHaveKey('help', 'foo-help')
        ->toHaveKey('success', 'foo-success');
});

it('ignores invalid icon names', function () {
    $set = new FooIconSet();
    $service = (new IconService())
        ->registerIconSet($set)
        ->setIconSet($set->name());

    expect($service->getIcons())->not->toHaveKey('bing');
});

it('throws exception for unknown icons', function () {
    $set = new FooIconSet();
    $service = (new IconService())
        ->registerIconSet($set)
        ->setIconSet($set->name());

    expect(fn () => $service->getIcon('bing'))->toThrow(InvalidIconException::class);
});

it('allows custom icon replacements', function () {
    $set = new FooIconSet();
    $service = (new IconService())
        ->registerIconSet($set)
        ->setIconSet($set->name());

    expect($service->getIcons())->toHaveKey('info', 'foo-info');

    $service->setCustomIcons(['info' => 'custom-info']);

    expect($service->getIcons())->toHaveKey('info', 'custom-info');
});

it('allows custom icons outside of the default icon set', function () {
    $set = new FooIconSet();
    $service = (new IconService())
        ->registerIconSet($set)
        ->setIconSet($set->name());

    expect($service->getIcons())->not->toHaveKey('bing')
        ->and(fn () => $service->getIcon('bing'))->toThrow(InvalidIconException::class);

    $service->setCustomIcons(['bing' => 'custom-bing']);

    expect($service->getIcons())->toHaveKey('bing', 'custom-bing')
        ->and(fn () => $service->getIcon('bing'))->not->toThrow(InvalidIconException::class)
        ->and($service->getIcon('bing'))->toBe('custom-bing');
});

class FooIconSet implements IconSet
{
    public function name(): string
    {
        return 'foo';
    }

    public function enabled(): bool
    {
        return true;
    }

    public function icons(): array
    {
        return [
            'alert' => 'foo-other-alert',
            'bing' => 'foo-bing',
        ];
    }
}

class BarIconSet implements IconSet
{
    public function name(): string
    {
        return 'bar';
    }

    public function enabled(): bool
    {
        return false;
    }

    public function icons(): array
    {
        return [];
    }
}
