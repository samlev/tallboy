Tallboy Blade Components
========================
Tallboy provides a number of blade components to make working with common UI elements easier. These components are
designed to be flexible and easy to use, while still providing a consistent look and feel across your application. The
intention is not to encapsulate every single possible UI element, but to provide a solid foundation that can be easily
extended in your application by using reusable pieces that add consistent functionality.

## Customising Views
All views included in Tallboy can be published to your own views directory by running the following command:
```shell
php artisan vendor:publish --tag=tallboy-views
```
This will copy all the views to `resources/views/vendor/tallboy`, where you can then customise them to suit your own
needs.

## Customising Component Functionality
If you need to modify the functionality of a specific component across your project, you can create your own component
that extends the original, and update the tallboy configuration file to point to your new component. This will allow you
to effectively replace a component with your own version, while still being able to use other tallboy components that.
may reference the common component.

For example, if you wanted to change add functionality to field errors, you might create a new component like so:
```php
namespace App\View\Components\Form;

use Tallboy\Form\FieldError as TallboyFieldError;

class FieldError extends TallboyFieldError {
    public function __construct(
        public bool $alwaysShow = false,
    ) {
        //
    }
}
```
Then you could swap this component in for the original by updating the tallboy configuration file like so:
```php

return [
    // ...
    'components' => [
        // ...
        'form' => [
            // ...
            'field-error' => \App\View\Components\Form\FieldError::class,
            // ...
        ],
        // ...
    ],
];
```
