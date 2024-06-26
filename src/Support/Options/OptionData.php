<?php

namespace Tallboy\Support\Options;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\View\ComponentAttributeBag;

/**
 * @implements Arrayable<string, string|bool|null>
 */
final class OptionData implements Arrayable, Optionable
{
    public function __construct(
        public readonly string $value,
        public readonly ?string $label = null,
        public bool $selected = false,
        public bool $disabled = false,
    ) {
        //
    }

    /**
     * @template TOptionArray of array{value: string|int, label?: ?string, selected?: bool, disabled?: bool}
     * @template TValue of int|string|Model|Optionable|TOptionArray
     *
     * @param TOptionArray|array<array-key, TValue>|string|Model|Optionable $value
     */
    public static function make(
        array|string|Model|Optionable $value,
        ?string $label = null,
        ?bool $selected = null,
        ?bool $disabled = null,
    ): self {
        // If only the first argument was passed do some checks to see if we can extract the value from it.
        if (empty(array_filter([$label, $selected, $disabled], fn ($v) => $v !== null))) {
            // Convert if the input is a valid json string
            if (is_string($value) && json_validate($value)) {
                $value = json_decode($value, true);
            }

            // If the label is an array, check to see if it's a valid option array
            if (
                is_array($value)
                && count($value) >= 1
                // We must have at least a label
                && Arr::has($value, 'value')
                // And we don't have any other keys except for the ones we expect
                && count($value) === count(Arr::only($value, ['value', 'label', 'selected', 'disabled']))
            ) {
                // Enforce types while preserving null and empty-ish values
                $transform = fn ($key, $callback) => ($value[$key] ?? null) !== null ? $callback($value[$key]) : null;

                $label = $transform('label', strval(...));
                $selected = $transform('selected', boolval(...));
                $disabled = $transform('disabled', boolval(...));
                $value = $value['value'];
            }
        }

        return new self(
            value: (string) match (true) {
                is_string($value) => $value,
                $value instanceof Model, $value instanceof Optionable => $value->getKey(),
                is_array($value) && array_is_list($value) => $value[0] ?? null,
                is_array($value) && count($value) === 1 => array_keys($value)[0],
                is_array($value) => $value['value'] ?? $value['key'] ?? $value['id'] ?? head($value),
                default => null,
            },
            label: match (true) {
                is_string($label) => $label,
                $value instanceof Optionable => $value->getLabel(),
                is_array($value) && array_is_list($value) => $value[1] ?? last($value),
                is_array($value) && count($value) === 1 => array_values($value)[0],
                is_array($value) => $value['label'] ?? $value['name'] ?? last($value),
                default => $label,
            },
            selected: $selected ?? false,
            disabled: $disabled ?? false,
        );
    }

    public function attributes(): ComponentAttributeBag
    {
        return new ComponentAttributeBag([
            'value' => $this->value,
            'selected' => $this->selected,
            'disabled' => $this->disabled,
        ]);
    }

    /**
     * @return array{value: string, label: ?string, selected: bool, disabled: bool}
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label,
            'selected' => $this->selected,
            'disabled' => $this->disabled,
        ];
    }

    public function getKey(): int|string
    {
        return $this->value;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }
}
