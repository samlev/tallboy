<?php

declare(strict_types=1);

namespace Tallboy;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Tallboy\Concerns\Icons\IconService;
use Tallboy\Concerns\Icons\IconSet;
use Tallboy\Concerns\Icons\Sets\TallboiconSet;

class TallboyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
        $this->registerIconService();
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tallboy.php' => config_path('tallboy.php'),
            ], 'config');
        }

        $this->bootDirectives();
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tallboy.php', 'tallboy');
    }

    protected function bootDirectives(): void
    {
        Blade::directive('icon', fn ($expression) => "<?php echo e(icon($expression)); ?>");
    }

    protected function registerIconService(): void
    {
        $this->app->singleton(IconService::class, function ($app) {
            $service = new IconService();

            $config = $this->app->make('config');
            /** @var ?string $selected */
            $selected = $config->get('tallboy.icons.default');
            $sets = Arr::wrap($config->get('tallboy.icons.sets', []));

            foreach ($sets as $set) {
                $concrete = $this->app->make($set);
                if ($concrete instanceof IconSet && $concrete->enabled()) {
                    $service->registerIconSet($concrete);
                    $selected ??= $concrete->name();
                }
            }

            $default = new TallboiconSet();
            $service->registerIconSet($default)
                ->setIconSet($selected ?: $default->name())
                ->setCustomIcons(Arr::wrap($config->get('tallboy.icons.custom', [])));

            return $service;
        });
    }
}
