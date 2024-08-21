<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;
use Tallboy\View\Component;

class FieldHint extends Component
{
    public function render(): View
    {
        return view('tallboy::components.form.field-hint');
    }
}
