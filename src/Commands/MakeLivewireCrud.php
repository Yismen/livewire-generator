<?php

namespace Dainsys\LivewireGenerator\Commands;

use Illuminate\Console\Command;

class MakeLivewireCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire-crud:make
        {model? : Model}
        {--force : Override existing files!}
        {--preset=tailwind : Frontend scafold preset!}
        {--models-dir=App\Models : Here you can specify your models directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a livewire component paginated';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('model');
        $force = $this->option('force');
        $preset = $this->option('preset');
        $models_dir = $this->option('models-dir');

        $this->call('make:livewire-crud', [
            'model' => $model,
            '--force' => $force,
            '--preset' => $preset,
            '--models-dir' => $models_dir,
        ]);
    }
}
