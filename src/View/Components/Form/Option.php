<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Tallboy\Support\Options\OptionData;

class Option extends Component
{
    public function __construct(
        public ?OptionData $option = null,
        public ?string $value = null,
        public ?string $label = null,
    ) {
        //
    }

    public function render(): View
    {
        return view('tallboy::components.form.option');
    }
}
