<?php

namespace Dainsys\LivewireGenerator\Commands;

use Dainsys\LivewireGenerator\Exceptions\MissingModelException;
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
        'tailwind' => \Dainsys\LivewireGenerator\Generators\Tailwind::class,
        'bootstrap' => \Dainsys\LivewireGenerator\Generators\Bootstrap::class,
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

        $generator = new $this->generators[$this->option('preset')](
            $this->modelName,
            $this->option('force'),
            $this->option('models-dir'),
        );

        $generator->handle();

        foreach ($generator->warns as $value) {
            foreach ($value as $message) {
                $this->warn($message);
            }
        }

        foreach ($generator->infos as $value) {
            foreach ($value as $message) {
                $this->info($message);
            }
        }
    }
    /**
     * Handle the arguments and assign them as variables
     *
     * @return Command
     */
    protected function handleArguments()
    {
        $this->modelName = Str::studly($this->argument('model'));

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
