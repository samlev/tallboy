<?php

declare(strict_types=1);

namespace Tallboy\Features\SupportIcons;

use BladeUI\Icons\Svg;
use Tallboy\Exceptions\Icons\InvalidIconException;
use Tallboy\Exceptions\Icons\InvalidIconSetException;
use Tallboy\Icons\IconSet;

class IconService
{
    /** @var string[]  */
    public const NOTIFICATION_ICONS = [
        'alert',
        'info',
        'error',
        'help',
        'success',
    ];

    /** @var string[]  */
    public const DROPDOWN_ICONS = [
        'dropdown',
        'menu',
        'close',
    ];

    /** @var string[]  */
    public const FILTER_ICONS = [
        'filter',
        'sort',
        'unsorted',
        'next',
        'previous',
        'reset',
        'refresh',
    ];

    /** @var string[]  */
    public const LOADING_ICONS = [
        'loading',
        'upload',
        'download',
    ];

    /** @var string[]  */
    public const FORM_ICONS = [
        'edit',
        'delete',
        'cancel',
        'save',
        'add',
        'remove',
        'mask',
        'unmask',
        'copy',
    ];

    /** @var string[]  */
    public const MISC_ICONS = [
        'dark',
        'light',
        'system',
    ];

    /** @var string[]  */
    public const ICONS = [
        ...self::NOTIFICATION_ICONS,
        ...self::DROPDOWN_ICONS,
        ...self::FILTER_ICONS,
        ...self::LOADING_ICONS,
        ...self::FORM_ICONS,
        ...self::MISC_ICONS,
    ];

    protected string $iconSet = '';
    /** @var array<string, string>  */
    protected array $icons = [];
    /** @var array<string, string>  */
    protected array $custom = [];
    /** @var array<string, array<string, string>>  */
    protected array $iconSets = [];

    /**
     * @param array<array-key, mixed> $attrs
     */
    public function icon(string $name, string $class = '', array $attrs = []): Svg
    {
        return svg(
            $this->getIcon($name),
            $class,
            [
                ...$attrs,
                'x-icon' => $name
            ]
        );
    }

    /**
     * @param array<string, string> $overrides
     */
    public function setCustomIcons(array $overrides): self
    {
        $this->custom = array_filter(
            $overrides,
            fn (string $icon, int|string $key) => $key && is_string($key) && trim($icon),
            ARRAY_FILTER_USE_BOTH
        );

        return $this;
    }

    public function setIconSet(string $iconSet): self
    {
        if (! $this->hasIconSet($iconSet)) {
            throw InvalidIconSetException::make($iconSet);
        }
        $this->iconSet = $iconSet;
        $this->icons = $this->iconSets[$iconSet];

        return $this;
    }

    public function registerIconSet(IconSet $iconSet): self
    {
        if ($iconSet->enabled()) {
            $name = $iconSet->name();
            $this->iconSets[$name] = [];
            $overrides = $iconSet->icons();

            foreach (self::ICONS as $icon) {
                $this->iconSets[$name][$icon] = trim($overrides[$icon] ?? '') ?: $name . '-' . $icon;
            }
        }

        return $this;
    }

    public function hasIconSet(string $name): bool
    {
        return ! empty($this->iconSets[$name]);
    }

    public function getIconSet(): string
    {
        return $this->iconSet;
    }

    /**
     * @return array<string, string>
     */
    public function getIcons(): array
    {
        return [
            ...$this->icons,
            ...$this->custom,
        ];
    }

    public function getIcon(string $name): string
    {
        return $this->custom[$name]
            ?? $this->icons[$name]
            ?? throw InvalidIconException::make($name, $this->iconSet);
    }
}
