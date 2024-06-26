<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

abstract class BaseInput extends Component
{
    public bool $fullWidth = true;
    public bool $showErrors = true;
    public bool $stacked = false;
    public ?string $placeholder = null;
    public ?string $label = null;
    /**
     * @var string[]|string|null $hint
     */
    public array|string|null $hint = null;
    /**
     * @var string[]|string|null $errorBags
     */
    public string|array|null $errorBags = null;
    /**
     * @var string[]|string|null $messages
     */
    public string|array|null $messages = null;

    /**
     * @return string[]
     */
    public function getErrorBags(): array
    {
        return collect(Arr::wrap($this->errorBags))
            ->merge($this->possibleFieldNames())
            ->values()
            ->unique()
            ->filter()
            ->all();
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return collect(Arr::wrap($this->messages))
            ->unique()
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return string[]
     */
    public function getHints(): array
    {
        return array_filter(Arr::wrap($this->hint));
    }

    public function guessLabel(): string
    {
        return $this->label ?: str($this->placeholder ?: $this->guessName())->headline()->toString();
    }

    protected function guessName(): string
    {
        return $this->possibleFieldNames()[0] ?? '';
    }

    /**
     * @return string[]
     */
    protected function possibleFieldNames(): array
    {
        return collect([$this->attributes->get('name')])
            ->merge($this->attributes->whereStartsWith('x-model')->getAttributes())
            ->merge($this->attributes->whereStartsWith('wire:model')->getAttributes())
            ->unique()
            ->filter(fn ($name) => is_string($name) && trim($name))
            ->values()
            ->all();
    }
}
