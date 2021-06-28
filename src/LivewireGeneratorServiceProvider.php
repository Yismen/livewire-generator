<?php

namespace Dainsys\LivewireGenerator;

use Illuminate\Support\ServiceProvider;

class LivewireGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Dainsys\LivewireGenerator\Commands\LivewireCrud::class,
                \Dainsys\LivewireGenerator\Commands\MakeLivewireCrud::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/livewire-generator.php' => config_path('livewire-generator.php'),
        ], 'livewire-generator:config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/livewire-generator.php',
            'livewire-generator'
        );
    }
}
