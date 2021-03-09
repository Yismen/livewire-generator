<?php

namespace Dainsys\LivewireGenerator;

use Dainsys\LivewireGenerator\Commands\LivewireCrud;
use Illuminate\Support\ServiceProvider;

class LivewireGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LivewireCrud::class
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
