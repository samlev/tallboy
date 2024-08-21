<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;
use Tallboy\View\Component;
use Tallboy\View\Data\Options\OptGroupData;

class OptGroup extends Component
{
    public ?OptGroupData $group = null;
    public ?string $label = null;

    public function render(): View
    {
        return view('tallboy::components.form.opt-group');
    }
}
