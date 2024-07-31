<?php

declare(strict_types=1);

namespace Tallboy\Icons;

use BladeUI\Icons\Factory;

class HeroiconSet implements IconSet
{
    public function name(): string
    {
        return 'heroicon';
    }

    public function enabled(): bool
    {
        return isset(app(Factory::class)->all()['heroicon']);
    }

    public function icons(): array
    {
        return [
            # Notification icons
            'alert' => 'heroicon-o-exclamation-triangle',
            'info' => 'heroicon-o-information-circle',
            'error' => 'heroicon-o-shield-exclamation',
            'help' => 'heroicon-o-question-mark-circle',
            'success' => 'heroicon-o-check-circle',

            # Dropdown and modal icons
            'dropdown' => 'heroicon-o-chevron-down',
            'menu' => 'heroicon-o-bars-3',
            'close' => 'heroicon-o-x-mark',

            # Filter icons
            'filter' => 'heroicon-o-funnel',
            'sort' => 'heroicon-o-chart-bar',
            'unsorted' => 'heroicon-o-bars-3-center-left',
            'next' => 'heroicon-o-chevron-double-right',
            'previous' => 'heroicon-o-chevron-double-left',
            'reset' => 'heroicon-o-arrow-uturn-left',
            'refresh' => 'heroicon-o-arrow-path',

            # Loading icons
            'loading' => 'heroicon-o-arrow-path',
            'upload' => 'heroicon-o-arrow-up-on-square',
            'download' => 'heroicon-o-arrow-down-on-square',

            # Form icons
            'edit' => 'heroicon-o-pencil-square',
            'delete' => 'heroicon-o-trash',
            'cancel' => 'heroicon-o-no-symbol',
            'save' => 'heroicon-o-inbox-arrow-down',
            'add' => 'heroicon-o-squares-plus',
            'remove' => 'heroicon-o-minus-circle',
            'mask' => 'heroicon-o-eye-slash',
            'unmask' => 'heroicon-o-eye',
            'copy' => 'heroicon-o-clipboard',

            # Misc icons
            'dark' => 'heroicon-o-moon',
            'light' => 'heroicon-o-sun',
            'system' => 'heroicon-o-computer-desktop',
        ];
    }
}
