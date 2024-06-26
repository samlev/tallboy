<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Tallboy\Support\Options\OptionData;

class Option extends Component
{
    public ?OptionData $option;
    public ?string $value;
    public ?string $label;

    public function render(): View
    {
        return view('tallboy::components.form.option');
    }
}
