<?php

declare(strict_types=1);

namespace Tallboy\Icons;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;

class HeroiconSet implements IconSet
{
    public function name(): string
    {
        return 'heroicon';
    }

    public function enabled(): bool
    {
        return class_exists(BladeHeroiconsServiceProvider::class);
    }

    public function icons(): array
    {
        return [
            # Notification icons
            'alert' => 'heroicon-exclamation-triangle',
            'info' => 'heroicon-information-circle',
            'error' => 'heroicon-shield-exclamation',
            'help' => 'heroicon-question-mark-circle',
            'success' => 'heroicon-check-circle',

            # Dropdown and modal icons
            'dropdown' => 'heroicon-chevron-down',
            'menu' => 'heroicon-bars-3',
            'close' => 'heroicon-x-mark',

            # Filter icons
            'filter' => 'heroicon-funnel',
            'sort' => 'heroicon-chart-bar',
            'unsorted' => 'heroicon-bars-3-center-left',
            'next' => 'heroicon-chevron-double-right',
            'previous' => 'heroicon-chevron-double-left',
            'reset' => 'heroicon-arrow-uturn-left',
            'refresh' => 'heroicon-arrow-path',

            # Loading icons
            'loading' => 'heroicon-arrow-path',
            'upload' => 'heroicon-arrow-up-on-square',
            'download' => 'heroicon-arrow-down-on-square',

            # Form icons
            'edit' => 'heroicon-pencil-square',
            'delete' => 'heroicon-trash',
            'cancel' => 'heroicon-no-symbol',
            'save' => 'heroicon-inbox-arrow-down',
            'add' => 'heroicon-squares-plus',
            'remove' => 'heroicon-minus-circle',
            'mask' => 'heroicon-eye-slash',
            'unmask' => 'heroicon-eye',
            'copy' => 'heroicon-clipboard',

            # Misc icons
            'dark' => 'heroicon-moon',
            'light' => 'heroicon-sun',
            'system' => 'heroicon-computer-desktop',
        ];
    }
}
