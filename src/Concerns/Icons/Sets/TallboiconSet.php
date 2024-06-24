<?php

declare(strict_types=1);

namespace Tallboy\Concerns\Icons\Sets;

use Tallboy\Concerns\Icons\IconSet;

class TallboiconSet implements IconSet
{
    public function name(): string
    {
        return 'tallboicon';
    }

    public function enabled(): bool
    {
        return true;
    }

    public function icons(): array
    {
        // All icons are named after the set of icons in the icon service
        return [];
    }
}
