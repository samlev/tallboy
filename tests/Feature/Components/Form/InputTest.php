<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

beforeEach(function () {
    View::share('errors', new ViewErrorBag());
});

it('renders the component', function () {
    $template = '<x-form.input />';
    expect(Blade::render($template))
        ->toContain('label')
        ->toContain('input type="text"');
});
