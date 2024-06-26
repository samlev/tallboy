<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Tallboy\Support\Options\OptGroupData;

class OptGroup extends Component
{
    public ?OptGroupData $group;
    public ?string $label;

    public function render(): View
    {
        return view('tallboy::components.form.opt-group');
    }
}
