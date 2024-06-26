<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

class InputErrors extends Component
{
    /** @var string[] */
    public array $fields = [];
    /** @var string[] */
    public array $messages = [];

    public function render(): View
    {
        return view('tallboy::components.form.input-errors');
    }

    /**
     * @return string[]
     */
    public function allErrors(ViewErrorBag $errors): array
    {
        $fieldErrors = collect($this->fields)
            ->flatmap(fn ($field) => $errors->get($field))
            ->all();

        return collect($this->messages)
            ->merge($fieldErrors)
            ->flatten()
            ->unique()
            ->filter(fn ($error) => is_string($error) && $error)
            ->values()
            ->all();
    }
}
