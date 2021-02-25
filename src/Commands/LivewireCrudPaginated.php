<?php

namespace Dainsys\LivewireGenerator\Commands;

use Dainsys\LivewireGenerator\Exceptions\MissingModelException;
use Dainsys\LivewireGenerator\Exceptions\MissingNameException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LivewireCrudPaginated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire-crud-paginated
        {name? : Component Name}{model? : Model}{--force : Override existing files!}';

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
    protected $viewsPath;

    protected $classesPath;
    protected string $stubsPath;

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

        $this->viewsPath = resource_path('/views/livewire');

        $this->classesPath = app_path('/Http/Livewire');

        $this->stubsPath = __DIR__ . '/../../stubs/paginated';
        $this->handleArguments();

        $this->handlePaginationTrait()
            ->handleCopyIcons()
            ->createMainView()
            ->createMainComponent()
            ->createFormView()
            ->createFormComponent()
            ->createDetailView()
            ->createDetailComponent();
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
    /**
     * Handle PaginationTrait stub.
     *
     * @return Command
     */
    protected function handlePaginationTrait(): Command
    {
        $destinationPath = $this->classesPath . '/PaginationTrait.php';

        $content = File::get($this->stubsPath . '/class-pagination.stub');

        return $this->createFile($destinationPath, $content, $warnFileExists = false, $this->classesPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Command
     */
    protected function createMainView(): Command
    {
        $kebabName = Str::kebab($this->componentName);
        $destinationPath = "{$this->viewsPath}/{$kebabName}.blade.php";

        $content = $this->parseContent(File::get($this->stubsPath . '/view-main.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Command
     */
    protected function createMainComponent(): Command
    {
        $destinationPath = "{$this->classesPath}/{$this->componentName}.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/class-main.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->classesPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Command
     */
    protected function createFormView(): Command
    {
        $kebabName = Str::kebab($this->componentName);
        $destinationPath = "{$this->viewsPath}/{$kebabName}-form.blade.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/view-form.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Command
     */
    protected function createFormComponent(): Command
    {
        $destinationPath = "{$this->classesPath}/{$this->componentName}Form.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/class-form.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->classesPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Command
     */
    protected function createDetailView(): Command
    {
        $kebabName = Str::kebab($this->componentName);
        $destinationPath = "{$this->viewsPath}/{$kebabName}-detail.blade.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/view-detail.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Command
     */
    protected function createDetailComponent(): Command
    {
        $destinationPath = "{$this->classesPath}/{$this->componentName}Detail.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/class-detail.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->classesPath);
    }
    /**
     * Handle Icons stub.
     *
     * @return Command
     */
    protected function handleCopyIcons(): Command
    {
        File::copyDirectory($this->stubsPath . '/../icons', resource_path('/views/livewire/icons'));

        return $this;
    }
    /**
     * Create the file on the given path with the string content
     *
     * @param string $destinationPath
     * @param string $content
     * @return Command
     */
    protected function createFile(string $destinationPath, string $content, bool $warnFileExists = true, string $destinationDir): Command
    {
        if (File::exists($destinationPath)) {
            if (!$this->option('force')) {
                if ($warnFileExists) {
                    $this->warn("File {$destinationPath} exists. Pass the --force flag to override. File Not created!");
                }
                return $this; // Do nothing
            }
        }

        if (!File::isDirectory($destinationDir)) {
            File::makeDirectory($destinationDir);
        }

        File::put($destinationPath, $content);

        if ($warnFileExists) {
            $this->info("Created file {$destinationPath}");
        }

        return $this;
    }

    protected function parseContent($content)
    {
        $content = str_replace('[component-name]', $this->componentName, $content);
        $content = str_replace('[component-name-kebab]', Str::kebab($this->componentName), $content);
        $content = str_replace('[model-plural]', Str::of($this->modelName)->studly()->plural(), $content);
        $content = str_replace('[model-snake-plural]', Str::of($this->modelName)->snake()->plural(), $content);
        $content = str_replace('[model-snake]', Str::snake($this->modelName), $content);
        $content = str_replace('[model]', $this->modelName, $content);
        $content = str_replace('[models-path]', config('livewire-generator.models_path'), $content);

        return $content;
    }
}
