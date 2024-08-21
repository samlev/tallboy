<?php

declare(strict_types=1);

namespace Tallboy\View\Data\Options;

interface Optionable
{
    public function getKey(): int|string;
    public function getLabel(): ?string;
}
