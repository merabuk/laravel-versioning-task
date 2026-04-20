<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());

        $this->prepareMorphMap(config('app.model_morph_map'));
    }

    /**
     * @param class-string[] $morphable
     */
    private function prepareMorphMap(array $morphable): void
    {
        Relation::enforceMorphMap(
            Arr::mapWithKeys($morphable, static fn (string $class) => [
                Str::snake(class_basename($class)) => $class,
            ])
        );
    }
}
