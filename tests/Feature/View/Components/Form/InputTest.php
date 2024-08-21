<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Tests\Support\QueriesDomElements;

uses(QueriesDomElements::class);

beforeEach(function () {
    View::share('errors', new ViewErrorBag());
});

it('renders the component', function () {
    $rendered = $this->getDocument(Blade::render('<x-form.input />'));
    $label = $this->getNode($rendered, 'label');
    $input = $this->getNode($rendered, 'input');

    expect($input)->not->toBeNull()
        ->and($input->attributes->getNamedItem('type')?->textContent)->toBe('text')
        ->and($label)->not->toBeNull()
        ->and($label->parentElement)->toBeNull()
        ->and($this->getAncestorNodes($input))->toContain($label);
});

it('passes additional attributes to the base input', function () {
    $rendered = $this->getDocument(Blade::render(
        '<x-form.input type="email" placeholder="Foo" label="Bar" name="baz" :messages="$messages" />',
        ['messages' => ['Bing', 'Bang', 'Bong']],
    ));
    $input = $this->getNode($rendered, 'input');
    $label = $this->getNode($rendered, 'label');
    $messages = $this->getNodes($rendered, 'ul > li');

    expect($input)->not->toBeNull()
        ->and($input->attributes)->not->toBeNull()
        ->and($input->attributes->getNamedItem('type')->textContent)->toBe('email')
        ->and($input->attributes->getNamedItem('placeholder')->textContent)->toBe('Foo')
        ->and($input->attributes->getNamedItem('name')->textContent)->toBe('baz')
        ->and($label->textContent)->toContain('Bar')
        ->and($messages->count())->toBe(3)
        ->and(trim($messages->item(0)->textContent))->toBe('Bing')
        ->and(trim($messages->item(1)->textContent))->toBe('Bang')
        ->and(trim($messages->item(2)->textContent))->toBe('Bong');
});

it('passes through label slot', function () {
    $rendered = $this->getDocument(
        Blade::render('<x-form.input><x-slot:label bar="baz"><b>Foo</b></x-slot:label></x-form.input>')
    );
    /** @var ?DOMElement $label */
    $label = $this->getNode($rendered, 'label');

    expect($label)->not->toBeNull()
        ->and($label->attributes->getNamedItem('bar')->textContent)->toBe('baz')
        ->and($label->firstElementChild)
        ->toHaveProperty('nodeName', 'b')
        ->toHaveProperty('textContent', 'Foo');
});
