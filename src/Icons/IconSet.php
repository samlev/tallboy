<?php

declare(strict_types=1);

namespace Tallboy\Icons;

interface IconSet
{
    public function name(): string;

    public function enabled(): bool;

    /**
     * @return array<non-empty-string, non-empty-string>
     */
    public function icons(): array;
}
