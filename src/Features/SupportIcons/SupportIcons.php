<?php

declare(strict_types=1);

namespace Tallboy\Features\SupportIcons;

use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Tallboy\Features\TallboyFeature;
use Tallboy\Icons\IconSet;
use Tallboy\Icons\TallboiconSet;

class SupportIcons extends TallboyFeature
{
    public function register(): void
    {
        $this->app->bind(IconService::class, function (Application $app) {
            $service = new IconService();

            /** @var ?string $selected */
            $selected = $this->config->get('tallboy.icons.default');
            $sets = Arr::wrap($this->config->get('tallboy.icons.sets', []));

            foreach ($sets as $set) {
                $concrete = $app->make($set);
                if ($concrete instanceof IconSet && $concrete->enabled()) {
                    $service->registerIconSet($concrete);
                    $selected ??= $concrete->name();
                }
            }

            $default = new TallboiconSet();
            $service->registerIconSet($default)
                ->setIconSet($selected ?: $default->name())
                ->setCustomIcons(Arr::wrap($this->config->get('tallboy.icons.custom', [])));

            return $service;
        });

        $this->app->alias(IconService::class, 'tallboy-icons');
    }

    public function boot(): void
    {
        Blade::directive('icon', fn ($expression) => "<?php echo e(icon($expression)); ?>");
    }

    public function provides(): array
    {
        return [
            IconService::class,
            'tallboy-icons',
        ];
    }
}
