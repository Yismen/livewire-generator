<?php

namespace Dainsys\LivewireGenerator\Commands;

use Dainsys\LivewireGenerator\Exceptions\MissingModelException;
use Dainsys\LivewireGenerator\Exceptions\MissingNameException;
use Dainsys\LivewireGenerator\Generators\Bootstrap;
use Dainsys\LivewireGenerator\Generators\Tailwind;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class LivewireCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire-crud
        {name? : Component Name}
        {model? : Model}
        {--force : Override existing files!}
        {--preset=tailwind : Frontend scafold preset!}
        {--models-dir=App\Models}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a livewire component paginated';
    /**
     * The name of the component
     *
     * @var string
     */
    protected $componentName;
    /**
     * The name of the model to be used
     *
     * @var string
     */
    protected $modelName;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $generators = [
        'tailwind' => Tailwind::class,
        'bootstrap' => Bootstrap::class,
    ];

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
        $this->handleArguments();

        $command = new $this->generators[$this->option('preset')](
            $this->componentName,
            $this->modelName,
            $this->option('force'),
            $this->option('models-dir'),
        );

        foreach ($command->warns as $warn) {
            $this->warn($warn);
        }

        foreach ($command->infos as $info) {
            $this->info($info);
        }
    }
    /**
     * Handle the arguments and assign them as variables
     *
     * @return Command
     */
    protected function handleArguments()
    {
        $this->componentName = Str::studly($this->argument('name'));
        $this->modelName = Str::studly($this->argument('model'));

        if (!$this->argument('name')) {
            $name = $this->ask("Enter Component Name");
            if (!$name || strlen($name) < 3) {
                throw new  MissingNameException("Please enter a component name with at leat 3 characters!");
            }
            $this->componentName = Str::studly($name);
        }

        if (!$this->argument('model')) {
            $model = $this->ask("Enter Model Name");
            if (!$model || strlen($model) < 2) {
                throw new  MissingModelException("Please enter a valid Model name!");
            }
            $this->modelName = Str::studly($model);
        }

        return $this;
    }
}
