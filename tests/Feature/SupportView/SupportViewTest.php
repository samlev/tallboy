<?php

declare(strict_types=1);

beforeEach(function () {
    app('view')->addNamespace('test', __DIR__ . '/views');
    app('blade.compiler')->anonymousComponentPath(__DIR__ . '/views/components', 'test');
});

it('registers blade directives', function (string $directive) {
    expect(app('blade.compiler')->getCustomDirectives())->toHaveKey($directive);
})->with([
    'isSlot',
    'elseIsSlot',
    'endIsSlot',
    'unlessIsSlot',
    'hasSlot',
    'elseHasSlot',
    'endHasSlot',
    'unlessHasSlot',
]);

it('only renders @isSlot for slots', function (string $template, string $expected, array $data = []) {
    expect(app('blade.compiler')->render(str_replace('target', 'is-slot', $template), $data))
        ->toContain($expected);
})->with('is-slot');

it('only renders @unlessIsSlot without slot', function (string $template, string $expected, array $data = []) {
    expect(app('blade.compiler')->render(str_replace('target', 'unless-is-slot', $template), $data))
        ->toContain($expected);
})->with('is-slot');

it('only renders @elseIsSlot without slot', function (string $template, string $expected, array $data = []) {
    expect(app('blade.compiler')->render(str_replace('target', 'else-is-slot', $template), $data))
        ->toContain($expected);
})->with('is-slot');

it('only renders @hasSlot for filled slots', function (string $template, string $expected, array $data = []) {
    expect(app('blade.compiler')->render(str_replace('target', 'has-slot', $template), $data))
        ->toContain($expected);
})->with('has-slot');

it('only renders @unlessHasSlot without filled slot', function (string $template, string $expected, array $data = []) {
    expect(app('blade.compiler')->render(str_replace('target', 'unless-has-slot', $template), $data))
        ->toContain($expected);
})->with('has-slot');

it('only renders @elseHasSlot without filled slot', function (string $template, string $expected, array $data = []) {
    expect(app('blade.compiler')->render(str_replace('target', 'else-has-slot', $template), $data))
        ->toContain($expected);
})->with('has-slot');

it('passes slot props down through components', function () {
    $blade = app('blade.compiler');

    expect($blade->render('test::test-child'))
        ->toContain('Foo Title', 'Foo body', 'header foo="bar"', 'main fizz="buzz"')
        ->and($blade->render('test::test-parent'))
        ->toContain('Parent Title', 'Foo body', 'header foo="bar" baz="quo"', 'main fizz="buzz" bing="bang"');
});

dataset('is-slot', [
    'slot' => ['<x-test::target><x-slot:foo>foo</x-slot:foo></x-test::target>', 'is slot'],
    'empty slot' => ['<x-test::target><x-slot:foo></x-slot:foo></x-test::target>', 'is slot'],
    'property as parameter' => ['<x-test::target foo="bar"></x-test::target>', 'is not slot'],
    'property as data' => ['<x-test::target></x-test::target>', 'is not slot', ['foo' => 'bar']],
    'undefined' => ['<x-test::target></x-test::target>', 'is not slot'],
]);

dataset('has-slot', [
    'slot' => ['<x-test::target><x-slot:foo>foo</x-slot:foo></x-test::target>', 'has slot'],
    'empty slot' => ['<x-test::target><x-slot:foo></x-slot:foo></x-test::target>', 'is empty slot'],
    'property as parameter' => ['<x-test::target foo="bar"></x-test::target>', 'is not slot'],
    'property as data' => ['<x-test::target></x-test::target>', 'is not slot', ['foo' => 'bar']],
    'undefined' => ['<x-test::target></x-test::target>', 'is not slot'],
]);
