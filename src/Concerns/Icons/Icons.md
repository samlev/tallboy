Icons
====================

Tallboy uses SVG icons for a number of its components. These icons are added into the system through the
[Blade Icons](https://blade-ui-kit.com/blade-icons) package. By default, Tallboy uses a minimal set of icons provided in
[Tallboicons](https://github.com/samlev/tallboicons). These are simple, utilitarian icons that are named for their
intended use within Tallboy.

## Usage
To use an icon, you can use the `x-icon` component. This component takes the name of the icon as a parameter, and will.
merge in any other attributes you pass to it:
```bladehtml
<x-icon name="loading" class="animate-spin" wire:loading />
```
You can also use the `@icon()` blade directive:
```bladehtml
@icon('success', 'stroke-green-500', ['x-cloak', 'x-show' => 'created'])
```
Finally, you can use the `icon()` helper function:
```bladehtml
{{ icon('error', 'fill-red-500', ['x-cloak', 'x-show' => 'error']) }}
```
These are effectively equivalent to the `@svg()` and `svg()` functions provided by Blade Icons, but with the added
benefit that they will automatically use your configured icon set.

**Warning:**
Note that these are not a drop-in replacement for the Blade Icons functions - if you request an icon which does not
exist in the set of "known" icons, an `InvalidIconException` will be thrown.

## Available Icons
You can find a list of all available icons in the [Tallboicons repository](https://github.com/samlev/tallboicons/tree/main/resources/svg).

### Icon Sets
By default, Tallboy uses the `tallboicons` icon set. This set of icons is pretty ugly, but it's a good starting point.
If you want to use a different icon set, you can easily install another icon set for bladeicons, and configure tallboy
to use it instead. The [blade-feathericon](https://github.com/brunocfalcao/blade-feather-icons) and
[blade-heroicons](https://github.com/blade-ui-kit/blade-heroicons) packages are both supported out of the box, with
roughly equivalent icons configured. If Tallboy detects that either of these packages is installed, it will use them by
default.

You can configure a specific icon set to use by setting the `tallboy.icons.default` config value to the name of the icon
set you wish to use:
```php
// config/tallboy.php
return [
    'icons' => [
        'default' => 'heroicon',
    ],
];
```
#### Custom Icon Sets
If you want to use a custom icon set, you can do so by creating a new icon set class that extends the `IconSet` class:

```php
namespace App\Icons;

use Tallboy\Concerns\Icons\IconSet;

class FontAwesomeIconSet implements IconSet
{
    public static function name(): string;
    {
        return 'fa';
    }
    
    public static function enabled(): bool
    {
        return true;
    }
    
    public function icons(): array
    {
        return [
            'alert' => 'fa-triangle-exclamation',
            'info' => 'fa-circle-info',
            // define any other icons that cannot be guessed as 'fa-<icon>'
            // e.g. 'download' => 'fa-download' does not need to be defined, as it can be guessed
        ];
    }
}
```
Then you can add this set to the configuration file:
```php
// config/tallboy.php
return [
    'icons' => [
        'default' => 'fa',
        'sets' => [
            App\Icons\FontAwesomeIconSet::class,
        ],
    ],
];
```
#### Overriding Individual Icons
If you want to override an individual icon, you can do so by adding a new icon to the `custom` array in the config:
```php
// config/tallboy.php
return [
    'icons' => [
        'default' => 'heroicon',
        'custom' => [
            'loading' => 'tallboicon-loading',
        ],
    ],
];
```
