<?php

declare(strict_types=1);

namespace Tallboy\View\Components;

use Closure;
use Illuminate\View\Component;

class Icon extends Component
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function render(): Closure
    {
        return function (array $data) {
            $attributes = $data['attributes']->getIterator()->getArrayCopy();

            $class = $attributes['class'] ?? '';

            unset($attributes['class']);

            return icon($this->name, $class, $attributes)->toHtml();
        };
    }
}
