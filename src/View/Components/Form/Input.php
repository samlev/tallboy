<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;

class Input extends BaseInput
{
    public function render(): View
    {
        return view('tallboy::components.form.input');
    }
}
