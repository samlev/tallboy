<?php

declare(strict_types=1);

namespace Tallboy\Features\SupportView;

use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\ComponentSlot;

class ViewService
{
    public function attributes(mixed $slot): ComponentAttributeBag
    {
        return (match (true) {
            $slot instanceof Component => $slot->attributes,
            $slot instanceof ComponentSlot => $slot->attributes,
            $slot instanceof ComponentAttributeBag => $slot,
            default => new ComponentAttributeBag([]),
        });
    }

    public function isSlot(mixed $slot): bool
    {
        return $slot instanceof ComponentSlot;
    }

    public function hasSlot(mixed $slot): bool
    {
        return $slot instanceof ComponentSlot && $slot->isNotEmpty();
    }
}
