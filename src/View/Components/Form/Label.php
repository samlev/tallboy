<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public function render(): View
    {
        return $this->view('tallboy::components.form.label');
    }
}
