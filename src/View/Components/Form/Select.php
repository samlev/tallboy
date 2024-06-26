<?php

declare(strict_types=1);

namespace Tallboy\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Enumerable;
use Tallboy\Support\Options\OptGroupData;
use Tallboy\Support\Options\Optionable;
use Tallboy\Support\Options\OptionData;

/**
 * @template TOption of string|array|Model|Optionable
 */
class Select extends BaseInput
{
    /**
     * @var array<array-key, TOption>|Enumerable<array-key, TOption> $options
     */
    public array|Enumerable $options = [];
    public bool $multiple = false;
    /**
     * @var string|int|string[]|int[]|null
     */
    public string|int|array|null $selected = null;

    public function render(): View
    {
        return view('tallboy::components.form.select', [
            'selectOptions' => $this->getOptions(),
        ]);
    }

    /**
     * @return array<OptionData|OptGroupData>
     */
    protected function getOptions(): array
    {
        $options = [];

        if ($this->placeholder) {
            $options[] = OptionData::make($this->placeholder, disabled: true);
        }

        $raw = is_array($this->options) ? $this->options : $this->options->all();
        $isList = array_is_list($raw);

        foreach ($raw as $key => $option) {
            $options[] = match (true) {
                is_string($key)
                && Arr::accessible($option)
                && array_is_list((array)$option) => OptGroupData::make($key, $option),
                ! $isList => OptionData::make($key, $option),
                default => OptionData::make($option),
            };
        }

        if ($this->selected) {
            $selected = Arr::wrap($this->selected);

            do {
                $this->markSelected($options, (string)array_pop($selected));
            } while ($this->multiple && $selected);
        }

        return $options;
    }

    /**
     * @param array<int, OptionData|OptGroupData> $options
     */
    protected function markSelected(array $options, string $selected): void
    {
        foreach ($options as $option) {
            if ($option instanceof OptGroupData) {
                $this->markSelected($option->options, $selected);
            } else {
                if ($option->value === $selected) {
                    $option->selected = true;
                    break;
                }
            }
        }
    }
}
