<?php

declare(strict_types=1);

namespace Tallboy\View\Data\Options;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Enumerable;

final class OptGroupData
{
    public function __construct(
        public readonly string $label,
        /** @var OptionData[] */
        public array $options = [],
    ) {
        //
    }

    /**
     * @template TOption of string|array|Model|Optionable
     *
     * @param string $label
     * @param array<array-key, TOption>|Enumerable<array-key, TOption> $options
     * @return self
     */
    public static function make(string $label, array|Enumerable $options): self
    {
        $options = is_array($options) ? $options : $options->all();
        $isList = array_is_list($options);

        return new self(
            label: $label,
            options: array_map(
                function ($key) use ($options, $isList) {
                    $option = $options[$key];
                    if ($isList) {
                        return OptionData::make($option);
                    }
                    return OptionData::make($key, $option);
                },
                array_keys($options)
            ),
        );
    }
}
