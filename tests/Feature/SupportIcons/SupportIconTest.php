<?php

declare(strict_types=1);

use BladeUI\Icons\Factory;
use Tallboy\Exceptions\Icons\InvalidIconSetException;
use Tallboy\Features\SupportIcons\IconService;
use Tallboy\Icons\FeathericonSet;
use Tallboy\Icons\HeroiconSet;
use Tallboy\Icons\IconSet;

it('registers default icon set', function () {
    $service = app(IconService::class);

    expect($service->hasIconSet('tallboicon'))->toBeTrue()
        ->and($service->hasIconSet('feathericon'))->toBeFalse()
        ->and($service->hasIconSet('heroicon'))->toBeFalse();
});

it('registers feathericon icon set if it is set', function () {
    app(Factory::class)->add('feathericon', ['prefix' => 'feathericon', 'paths' => [__DIR__]]);

    $service = app(IconService::class);

    expect($service->hasIconSet('tallboicon'))->toBeTrue()
        ->and($service->hasIconSet('feathericon'))->toBeTrue()
        ->and($service->hasIconSet('heroicon'))->toBeFalse();
});

it('registers heroicon icon set if it is set', function () {
    app(Factory::class)->add('heroicon', ['prefix' => 'heroicon', 'paths' => [__DIR__]]);

    $service = app(IconService::class);

    expect($service->hasIconSet('tallboicon'))->toBeTrue()
        ->and($service->hasIconSet('feathericon'))->toBeFalse()
        ->and($service->hasIconSet('heroicon'))->toBeTrue();
});

it('registers all default sets if they are set', function () {
    app(Factory::class)->add('feathericon', ['prefix' => 'feathericon', 'paths' => [__DIR__]]);
    app(Factory::class)->add('heroicon', ['prefix' => 'heroicon', 'paths' => [__DIR__]]);

    $service = app(IconService::class);

    expect($service->hasIconSet('tallboicon'))->toBeTrue()
        ->and($service->hasIconSet('feathericon'))->toBeTrue()
        ->and($service->hasIconSet('heroicon'))->toBeTrue();
});

it('allows custom icon sets', function () {
    app(Factory::class)->add('heroicon', ['prefix' => 'heroicon', 'paths' => [__DIR__]]);

    app('config')->set('tallboy.icons.sets', [
        BuzzIconSet::class,
        HeroiconSet::class,
    ]);

    $service = app(IconService::class);

    expect($service->hasIconSet('buzz'))->toBeTrue()
        ->and($service->hasIconSet('feathericon'))->toBeFalse()
        ->and($service->hasIconSet('heroicon'))->toBeTrue()
        ->and($service->hasIconSet('tallboicon'))->toBeTrue();
});

it('always registers tallboicon icon set', function () {
    app('config')->set('tallboy.icons.sets', null);

    $service = app(IconService::class);

    expect($service->hasIconSet('heroicon'))->toBeFalse()
        ->and($service->hasIconSet('feathericon'))->toBeFalse()
        ->and($service->hasIconSet('tallboicon'))->toBeTrue();
});

it('selects the configured icon set if the default is set', function () {
    app(Factory::class)->add('feathericon', ['prefix' => 'feathericon', 'paths' => [__DIR__]]);
    app(Factory::class)->add('heroicon', ['prefix' => 'heroicon', 'paths' => [__DIR__]]);

    $r = new \Random\Randomizer();

    $default = $r->shuffleArray([
        'buzz',
        'feathericon',
        'heroicon',
    ])[0];

    $sets = [
        BuzzIconSet::class,
        FeathericonSet::class,
        HeroiconSet::class,
    ];

    // ensure the default is not the first set
    while ((new $sets[0]())->name() === $default) {
        $sets = $r->shuffleArray($sets);
    }

    app('config')->set('tallboy.icons', [
        'default' => $default,
        'sets' => $sets
    ]);

    $first = new $sets[0]();

    $service = app(IconService::class);

    expect($service->hasIconSet('heroicon'))->toBeTrue()
        ->and($service->hasIconSet('feathericon'))->toBeTrue()
        ->and($service->hasIconSet('buzz'))->toBeTrue()
        ->and($service->hasIconSet('tallboicon'))->toBeTrue()
        ->and($service->getIconSet())->toBe($default)
        ->and($service->getIconSet())->not->toBe($first->name());
});

it('selects the first non-tallboicon icon set if the default is not set', function () {
    app(Factory::class)->add('feathericon', ['prefix' => 'feathericon', 'paths' => [__DIR__]]);
    app(Factory::class)->add('heroicon', ['prefix' => 'heroicon', 'paths' => [__DIR__]]);

    $r = new \Random\Randomizer();

    $sets = $r->shuffleArray([
        BuzzIconSet::class,
        FeathericonSet::class,
        HeroiconSet::class,
    ]);

    app('config')->set('tallboy.icons', [
        'default' => null,
        'sets' => $sets
    ]);

    $selected = new $sets[0]();

    $service = app(IconService::class);

    expect($service->hasIconSet('heroicon'))->toBeTrue()
        ->and($service->hasIconSet('feathericon'))->toBeTrue()
        ->and($service->hasIconSet('buzz'))->toBeTrue()
        ->and($service->hasIconSet('tallboicon'))->toBeTrue()
        ->and($service->getIconSet())->toBe($selected->name());
});

it('selects tallboicon if no default or other icon sets exist', function () {
    app('config')->set('tallboy.icons', [
        'default' => null,
        'sets' => null,
    ]);

    $service = app(IconService::class);

    expect($service->getIconSet())->toBe('tallboicon');
});

it('does not allow an invalid icon set as a default set', function () {
    app('config')->set('tallboy.icons.default', 'invalid');

    expect(fn () => app(IconService::class))
        ->toThrow(InvalidIconSetException::class);
});

it('allows custom icon replacements', function () {
    app('config')->set('tallboy.icons', [
        'default' => 'tallboicon',
        'custom' => [
            'alert' => 'foo-alert',
            'info' => 'feathericon-info',
        ],
    ]);

    $service = app(IconService::class);
    expect($service->getIcons())->toHaveKey('alert', 'foo-alert')
        ->toHaveKey('info', 'feathericon-info')
        ->toHaveKey('help', 'tallboicon-help');
});

it('allows custom icons outside of the default set', function () {
    app('config')->set('tallboy.icons', [
        'default' => 'tallboicon',
        'custom' => [
            'buzz' => 'bing-buzz',
        ],
    ]);

    $service = app(IconService::class);

    expect($service->getIcons())->toHaveKey('alert', 'tallboicon-alert')
        ->toHaveKey('info', 'tallboicon-info')
        ->toHaveKey('buzz', 'bing-buzz');
});

it('selects the correct icons for the selected icon set', function (string $set, string $expected) {
    app(Factory::class)->add('feathericon', ['prefix' => 'feathericon', 'paths' => [__DIR__]]);
    app(Factory::class)->add('heroicon', ['prefix' => 'heroicon', 'paths' => [__DIR__]]);

    app('config')->set('tallboy.icons.sets', [
        BuzzIconSet::class,
        HeroiconSet::class,
        FeathericonSet::class,
    ]);

    app('config')->set('tallboy.icons.default', $set);

    $service = app(IconService::class);

    expect($service->getIcon('alert'))->toBe($expected);
})->with([
    'buzz' => ['buzz', 'buzz-other-alert'],
    'feathericon' => ['feathericon', 'feathericon-alert-triangle'],
    'heroicon' => ['heroicon', 'heroicon-o-exclamation-triangle'],
    'tallboicon' => ['tallboicon', 'tallboicon-alert'],
]);

class BuzzIconSet implements IconSet
{
    public function name(): string
    {
        return 'buzz';
    }

    public function enabled(): bool
    {
        return true;
    }

    public function icons(): array
    {
        return [
            'alert' => 'buzz-other-alert',
        ];
    }
}
