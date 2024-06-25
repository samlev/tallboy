<?php

declare(strict_types=1);

namespace Tallboy;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Tallboy\Features\TallboyFeature;
use Tallboy\Features\SupportIcons\SupportIcons;
use Tallboy\Features\SupportView\SupportView;

class TallboyServiceProvider extends ServiceProvider
{
    /**
     * @var TallboyFeature[]
     */
    protected array $features = [];

    public function register(): void
    {
        $this->registerConfig();
        $this->registerFeatures();
    }

    public function boot(): void
    {
        if (class_exists(AboutCommand::class) && class_exists(InstalledVersions::class)) {
            AboutCommand::add('Tallboy', [
                'Tallboy' => InstalledVersions::getPrettyVersion('samlev/tallboy'),
            ]);
        }
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tallboy');
        $this->bootAssets();
        $this->bootFeatures();
    }

    protected function registerFeatures(): void
    {
        array_map(fn (TallboyFeature $feature) => $feature->register(), $this->getFeatures());
    }

    protected function bootFeatures(): void
    {
        array_map(fn (TallboyFeature $feature) => $feature->boot(), $this->getFeatures());
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tallboy.php', 'tallboy');
    }

    protected function bootAssets(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tallboy.php' => config_path('tallboy.php'),
            ], ['tallboy', 'tallboy-config']);
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/tallboy'),
            ], ['tallboy', 'tallboy-views']);
        }
    }

    /**
     * @return string[]
     */
    public function provides(): array
    {
        $provides = [];

        array_map(fn (TallboyFeature $feature) => array_push($provides, ...$feature->provides()), $this->getFeatures());

        return array_filter(array_unique($provides));
    }

    /**
     * @return TallboyFeature[]
     */
    protected function getFeatures(): array
    {
        if (empty($this->features)) {
            $this->features = array_map(fn (string $feature) => $this->app->make($feature), [
                SupportIcons::class,
                SupportView::class,
            ]);
        }

        return $this->features;
    }
}
