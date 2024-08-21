<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Tallboy\View\Component;

abstract class BaseInput extends Component
{
    /** @var string[] $errorBags */
    public array $errorBags = [];
    /** @var string[] $messages */
    public array $messages = [];
    /** @var string[] $hints */
    public array $hints = [];
    public bool $fullWidth = true;
    public bool $stacked = false;
    public bool $hideErrors = false;
    public ?string $label = null;
    public ?string $placeholder = null;

    public function shouldHideErrors(ComponentAttributeBag $attributes): bool
    {
        return $this->hideErrors || (empty($this->getErrorBags($attributes)) && empty($this->messages));
    }

    /**
     * @return string[]
     */
    public function getErrorBags(ComponentAttributeBag $attributes): array
    {
        return Collection::make($this->errorBags ?: $this->guessFieldNames($attributes))
            ->map(fn ($bag) => trim($bag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public function guessLabel(ComponentAttributeBag $attributes): string
    {
        return $this->label
            ?? Str::headline(
                $this->placeholder
                    ?: $this->guessFieldNames($attributes)[0]
                    ?? ''
            );
    }

    /**
     * @return string[]
     */
    protected function guessFieldNames(ComponentAttributeBag $attributes): array
    {
        return Collection::make([
            $attributes->get('name', ''),
            ...$attributes->whereStartsWith(['wire:model', 'x-model'])->getAttributes(),
            Str::snake($this->label ?? ''),
        ])
            ->map(fn ($name) => is_string($name) ? trim($name) : null)
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
