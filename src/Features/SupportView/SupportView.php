<?php

declare(strict_types=1);

namespace Tallboy\Features\SupportView;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Tallboy\Features\TallboyFeature;

class SupportView extends TallboyFeature
{
    public function register(): void
    {
        $this->app->bind(ViewService::class, fn () => new ViewService());
        $this->app->alias(ViewService::class, 'tallboy-view');
    }

    public function boot(): void
    {
        $this->bootSlotDirectives();

        Blade::components(array_filter(Arr::dot((array) $this->config->get('tallboy.components', []))));
    }

    protected function bootSlotDirectives(): void
    {
        foreach (['isSlot', 'hasSlot'] as $name) {
            Blade::directive(
                $name,
                fn ($expression) => "<?php if (isset({$expression}) && {$name}({$expression})) : ?>"
            );
            Blade::directive(
                'else' . ucfirst($name),
                fn ($expression) => "<?php elseif (isset({$expression}) && {$name}({$expression})) : ?>"
            );
            Blade::directive(
                'end' . ucfirst($name),
                fn ($expression) => '<?php endif; ?>'
            );
            Blade::directive(
                'unless' . ucfirst($name),
                fn ($expression) => "<?php if (! isset({$expression}) || !{$name}({$expression})) : ?>"
            );
        }
    }

    public function provides(): array
    {
        return [
            ViewService::class,
            'tallboy-view',
        ];
    }
}
