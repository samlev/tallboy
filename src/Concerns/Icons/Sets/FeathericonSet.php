<?php

declare(strict_types=1);

namespace Tallboy\Concerns\Icons\Sets;

use Tallboy\Concerns\Icons\IconSet;

class FeathericonSet implements IconSet
{
    public function name(): string
    {
        return 'feathericon';
    }

    public function enabled(): bool
    {
        return class_exists('Brunocfalcao\BladeFeatherIcons\BladeFeatherIconsServiceProvider');
    }

    public function icons(): array
    {
        return [
            # Notification icons
            'alert' => 'feathericon-alert-triangle',
            'error' => 'feathericon-alert-octogon',
            'help' => 'feathericon-help-circle',
            'success' => 'feathericon-check-circle',

            # Dropdown and modal icons
            'dropdown' => 'feathericon-chevron-down',
            'close' => 'feathericon-x',

            # Filter icons
            'sort' => 'feathericon-bar-chart',
            'unsorted' => 'feathericon-bar-chart-2',
            'next' => 'feathericon-chevrons-right',
            'previous' => 'feathericon-chevrons-left',
            'reset' => 'feathericon-rotate-ccw',
            'refresh' => 'feathericon-refresh-cw',

            # Loading icons
            'loading' => 'feathericon-loader',

            # Form icons
            'delete' => 'feathericon-trash-2',
            'cancel' => 'feathericon-slash',
            'add' => 'feathericon-plus-square',
            'remove' => 'feathericon-minus-circle',
            'mask' => 'feathericon-eye-off',
            'unmask' => 'feathericon-eye',
            'copy' => 'feathericon-clipboard',

            # Misc icons
            'dark' => 'feathericon-moon',
            'light' => 'feathericon-sun',
            'system' => 'feathericon-monitor',
        ];
    }
}
