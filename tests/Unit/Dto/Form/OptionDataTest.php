<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Tallboy\Support\Options\OptionData;
use Tallboy\Support\Options\Optionable;

it('makes option from strings', function () {
    $option = OptionData::make('foo', 'bar');

    expect($option->value)->toBe('foo')
        ->and($option->label)->toBe('bar');
});

it('makes option from array', function (array $input) {
    $option = OptionData::make($input);

    expect($option->value)->toBe('foo')
        ->and($option->label)->toBe('bar');
})->with([
    '[value => label]' => [['foo' => 'bar']],
    '[value, label]' => [['foo', 'bar']],
    '["value" => value, "label" => label]' => [['value' => 'foo', 'label' => 'bar']],
    '["key" => value, "label" => label]' => [['key' => 'foo', 'label' => 'bar']],
    '["id" => value, "label" => label]' => [['id' => 'foo', 'label' => 'bar']],
    '["value" => value, "name" => label]' => [['value' => 'foo', 'name' => 'bar']],
    '["key" => value, "name" => label]' => [['key' => 'foo', 'name' => 'bar']],
    '["id" => value, "name" => label]' => [['id' => 'foo', 'name' => 'bar']],
    '[Str::random() => value, Str::random() => label]' => [[Str::random() => 'foo', Str::random() => 'bar']],
]);

it('makes option from json', function (string $json) {
    $option = OptionData::make($json);

    expect($option->value)->toBe('foo')
        ->and($option->label)->toBe('bar');
})->with([
    '{"foo":"bar"}',
    '["foo","bar"]',
    '{"value":"foo","label":"bar"}',
    '{"key":"foo","label":"bar"}',
    '{"id":"foo","label":"bar"}',
    '{"value":"foo","name":"bar"}',
    '{"key":"foo","name":"bar"}',
    '{"id":"foo","name":"bar"}',
]);

it('makes option from option', function () {
    $option = OptionData::make(new OptionData('foo', 'bar'));

    expect($option->value)->toBe('foo')
        ->and($option->label)->toBe('bar');
});

it('makes option from model', function () {
    $id = rand(1, 200);
    $model = new class (['id' => $id]) extends Model {
        protected $fillable = ['id'];
    };

    $option = OptionData::make($model);

    expect($option->value)->toBe((string) $id)
        ->and($option->label)->toBeNull();
});

it('makes option from optionable', function () {
    $value = new class () implements Optionable {
        public function getKey(): int|string
        {
            return 'foo';
        }

        public function getLabel(): ?string
        {
            return 'bar';
        }
    };

    $option = OptionData::make($value);

    expect($option->value)->toBe('foo')
        ->and($option->label)->toBe('bar');
});

it('respects selected and disabled flags', function (bool $selected, bool $disabled) {
    $option = OptionData::make('foo', 'bar', selected: $selected, disabled: $disabled);

    expect($option->selected)->toBe($selected)
        ->and($option->disabled)->toBe($disabled);
})->with([
    'selected' => [true, false],
    'disabled' => [false, true],
    'both' => [true, true],
    'neither' => [false, false],
]);
