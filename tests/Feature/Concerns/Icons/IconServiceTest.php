<?php

declare(strict_types=1);

use Tallboy\Concerns\Icons\IconService;
use Tallboy\Concerns\Icons\IconSet;
use Tallboy\Exception\Icons\InvalidIconSetException;

it('registers default icon sets', function () {
    $service = app(IconService::class);

    expect($service->hasIconSet('heroicon'))->toBeTrue()
        ->and($service->hasIconSet('feathericon'))->toBeTrue()
        ->and($service->hasIconSet('tallboicon'))->toBeTrue();
});

it('allows custom icon sets', function () {
    app('config')->set('tallboy.icons.sets', [
        BuzzIconSet::class,
        \Tallboy\Concerns\Icons\Sets\HeroiconSet::class,
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
    $r = new \Random\Randomizer();

    $default = $r->shuffleArray([
        'buzz',
        'feathericon',
        'heroicon',
    ])[0];

    $sets = [
        BuzzIconSet::class,
        \Tallboy\Concerns\Icons\Sets\FeathericonSet::class,
        \Tallboy\Concerns\Icons\Sets\HeroiconSet::class,
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
    $r = new \Random\Randomizer();

    $sets = $r->shuffleArray([
        BuzzIconSet::class,
        \Tallboy\Concerns\Icons\Sets\FeathericonSet::class,
        \Tallboy\Concerns\Icons\Sets\HeroiconSet::class,
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
    app('config')->set('tallboy.icons.default', $set);

    $service = app(IconService::class);

    expect($service->getIcon('alert'))->toBe($expected);
})->with([
    'feathericon' => ['feathericon', 'feathericon-alert-triangle'],
    'heroicon' => ['heroicon', 'heroicon-exclamation-triangle'],
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
