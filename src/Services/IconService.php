<?php

declare(strict_types=1);

namespace Tallboy\Services;

use Tallboy\Exception\InvalidConfigurationException;

class IconService
{
    protected const TALLBOY = [
        # Notification icons
        'alert' => 'tallboicon-alert',
        'info' => 'tallboicon-info',
        'error' => 'tallboicon-error',
        'help' => 'tallboicon-help',
        'success' => 'tallboicon-success',

        # Dropdown and modal icons
        'dropdown' => 'tallboicon-dropdown',
        'menu' => 'tallboicon-menu',
        'close' => 'tallboicon-close',

        # Filter icons
        'filter' => 'tallboicon-filter',
        'sort' => 'tallboicon-sort',
        'unsorted' => 'tallboicon-unsorted',
        'next' => 'tallboicon-next',
        'previous' => 'tallboicon-previous',
        'reset' => 'tallboicon-reset',
        'refresh' => 'tallboicon-refresh',

        # Loading icons
        'loading' => 'tallboicon-loading',
        'upload' => 'tallboicon-upload',
        'download' => 'tallboicon-download',

        # Form icons
        'edit' => 'tallboicon-edit',
        'delete' => 'tallboicon-delete',
        'cancel' => 'tallboicon-cancel',
        'save' => 'tallboicon-save',
        'add' => 'tallboicon-add',
        'remove' => 'tallboicon-remove',
        'mask' => 'tallboicon-mask',
        'unmask' => 'tallboicon-unmask',
        'copy' => 'tallboicon-copy',

        # Misc icons
        'dark' => 'tallboicon-dark',
        'light' => 'tallboicon-light',
        'system' => 'tallboicon-system',
    ];

    protected const HEROICON = [
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

    protected const FEATHERICON = [
        # Notification icons
        'alert' => 'feathericon-alert-triangle',
        'info' => 'feathericon-info',
        'error' => 'feathericon-alert-octogon',
        'help' => 'feathericon-help-circle',
        'success' => 'feathericon-check-circle',

        # Dropdown and modal icons
        'dropdown' => 'feathericon-chevron-down',
        'menu' => 'feathericon-menu',
        'close' => 'feathericon-x',

        # Filter icons
        'filter' => 'feathericon-filter',
        'sort' => 'feathericon-bar-chart',
        'unsorted' => 'feathericon-bar-chart-2',
        'next' => 'feathericon-chevrons-right',
        'previous' => 'feathericon-chevrons-left',
        'reset' => 'feathericon-rotate-ccw',
        'refresh' => 'feathericon-refresh-cw',

        # Loading icons
        'loading' => 'feathericon-loader',
        'upload' => 'feathericon-upload',
        'download' => 'feathericon-download',

        # Form icons
        'edit' => 'feathericon-edit',
        'delete' => 'feathericon-trash-2',
        'cancel' => 'feathericon-slash',
        'save' => 'feathericon-save',
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

    public function __construct(
        protected ?string $iconSet,
        protected array $icons = [],
    ) {
        $this->iconSet ??= $this->guessIconSet();

        $this->icons = [
            ...match ($this->iconSet) {
                'tallboicon' => self::TALLBOY,
                'heroicon' => self::HEROICON,
                'feathericon' => self::FEATHERICON,
                default => throw new InvalidConfigurationException('Invalid icon set provided'),
            },
            ...$this->icons,
        ];
    }

    protected function guessIconSet(): string
    {
        return match (true) {
            class_exists('BladeUI\Heroicons\BladeHeroiconsServiceProvider') => 'heroicons',
            class_exists('Brunocfalcao\BladeFeatherIcons\BladeFeatherIconsServiceProvider') => 'feathericon',
            default => 'tallboicon',
        };
    }

    public function icon(string $name): string
    {
        return $this->icons[$name] ?: throw new InvalidConfigurationException('Invalid icon provided');
    }
}
