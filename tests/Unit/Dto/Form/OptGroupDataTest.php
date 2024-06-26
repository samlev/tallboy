<?php

use Illuminate\Database\Eloquent\Model;
use Tallboy\Support\Options\OptGroupData;
use Tallboy\Support\Options\OptionData;

it('makes options from array of strings', function () {
    $group = OptGroupData::make('foo', ['bar', 'baz']);

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('bar')
        ->and($group->options[0]->label)->toBeNull()
        ->and($group->options[1]->value)->toBe('baz')
        ->and($group->options[1]->label)->toBeNull();
});

it('makes options from associative array', function () {
    $group = OptGroupData::make('foo', ['bar' => 'baz', 'fizz' => 'buzz']);

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('bar')
        ->and($group->options[0]->label)->toBe('baz')
        ->and($group->options[1]->value)->toBe('fizz')
        ->and($group->options[1]->label)->toBe('buzz');
});

it('makes options from array of arrays', function () {
    $group = OptGroupData::make('foo', [['bar', 'baz'], ['fizz', 'buzz']]);

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('bar')
        ->and($group->options[0]->label)->toBe('baz')
        ->and($group->options[1]->value)->toBe('fizz')
        ->and($group->options[1]->label)->toBe('buzz');
});

it('makes options from array of associative arrays', function () {
    $group = OptGroupData::make('foo', [['value' => 'bar', 'label' => 'baz'], ['value' => 'fizz', 'label' => 'buzz']]);

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('bar')
        ->and($group->options[0]->label)->toBe('baz')
        ->and($group->options[1]->value)->toBe('fizz')
        ->and($group->options[1]->label)->toBe('buzz');
});

it('makes options from array of options', function () {
    $group = OptGroupData::make('foo', [new OptionData('bar', 'baz'), new OptionData('fizz', 'buzz')]);

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('bar')
        ->and($group->options[0]->label)->toBe('baz')
        ->and($group->options[1]->value)->toBe('fizz')
        ->and($group->options[1]->label)->toBe('buzz');
});

it('makes options from array of models', function () {
    $group = OptGroupData::make('foo', [
        new class (['id' => 1]) extends Model {
            protected $fillable = ['id'];
        },
        new class (['id' => 2]) extends Model {
            protected $fillable = ['id'];
        },
    ]);

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('1')
        ->and($group->options[0]->label)->toBeNull()
        ->and($group->options[1]->value)->toBe('2')
        ->and($group->options[1]->label)->toBeNull();
});

it('makes options from collection', function () {
    $group = OptGroupData::make('foo', collect(['bar', 'baz']));

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('bar')
        ->and($group->options[0]->label)->toBeNull()
        ->and($group->options[1]->value)->toBe('baz')
        ->and($group->options[1]->label)->toBeNull();
});

it('makes options from grouped collection', function () {
    $group = OptGroupData::make('foo', collect(['bar' => 'baz', 'fizz' => 'buzz']));

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('bar')
        ->and($group->options[0]->label)->toBe('baz')
        ->and($group->options[1]->value)->toBe('fizz')
        ->and($group->options[1]->label)->toBe('buzz');
});

it('makes options from a collection of options', function () {
    $group = OptGroupData::make('foo', collect([
        new OptionData('bar', 'baz'),
        new OptionData('fizz', 'buzz'),
    ]));

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('bar')
        ->and($group->options[0]->label)->toBe('baz')
        ->and($group->options[1]->value)->toBe('fizz')
        ->and($group->options[1]->label)->toBe('buzz');
});

it('makes options from a collection of models', function () {
    $group = OptGroupData::make('foo', collect([
        new class (['id' => 1]) extends Model {
            protected $fillable = ['id'];
        },
        new class (['id' => 2]) extends Model {
            protected $fillable = ['id'];
        },
    ]));

    expect($group->label)->toBe('foo')
        ->and($group->options)->toHaveCount(2)
        ->and($group->options[0]->value)->toBe('1')
        ->and($group->options[0]->label)->toBeNull()
        ->and($group->options[1]->value)->toBe('2')
        ->and($group->options[1]->label)->toBeNull();
});
