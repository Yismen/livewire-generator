<?php

namespace Dainsys\LivewireGenerator\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

abstract class Generator implements GeneratorContract
{
    /**
     * Dir location for views
     */
    protected string $viewsPath;
    /**
     * Dir location for the component class
     */
    protected string $mainFolderPath;
    /**
     * Override files if exists
     */
    protected bool $force;
    /**
     * The name of the model to be used
     */
    protected string $modelName;
    /**
     * Plural representation of model name: Activity = Activities
     */
    protected string $model_name_as_plural;
    /**
     * Snake representation of model name: ActivityStudent = activity_student
     */
    protected string $model_name_as_snake;
    /**
     * Kebab representation of model name: ActivityStudent = activity-student
     */
    protected string $model_name_as_kebab;
    /**
     * Plural snake representation of model name: Activity = activities
     */
    protected string $model_name_as_plural_snake;
    /**
     * Models directory
     */
    protected string $modelsDir;
    /**
     * Messages to report as warning
     */
    public array $warns = [];
    /**
     * Messages to report as info
     */
    public array $infos = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        string $modelName,
        bool $force = false,
        string $modelsDir = 'App\Models'
    ) {
        $this->viewsPath = resource_path('/views/livewire/' . Str::snake($modelName));

        $this->mainFolderPath = app_path('/Http/Livewire/' . $modelName);

        $this->modelsDir = $modelsDir;

        $this->force = $force;

        $this->modelName = $modelName;
        $this->model_name_as_plural =  Str::of($modelName)->studly()->plural()->__toString();
        $this->model_name_as_snake =  Str::of($modelName)->snake()->__toString();
        $this->model_name_as_plural_snake =  Str::of($modelName)->plural()->snake()->__toString();
        $this->model_name_as_kebab =  Str::of($modelName)->kebab()->__toString();
    }

    public function handle()
    {
        return $this
            ->handleCopyIcons()
            ->handlePaginationTrait()
            ->createIndexClassComponent()
            ->createIndexViewComponent()
            ->createFormComponent()
            ->createFormView()
            ->createDetailComponent()
            ->createDetailView();
    }
    /**
     * Handle PaginationTrait stub.
     *
     * @return Generator
     */
    protected function handlePaginationTrait(): Generator
    {
        $destinationPath = app_path('/Http/Livewire/PaginationTrait.php');

        $content = File::get($this->stubsPath . '/../pagination.stub');

        return $this->createFile($destinationPath, $content, $warnFileExists = false, app_path('/Http/Livewire'));
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createIndexClassComponent(): Generator
    {
        $destinationPath = "{$this->mainFolderPath}/{$this->modelName}Index.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/classes/main.stub'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->mainFolderPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createIndexViewComponent(): Generator
    {
        $destinationPath = "{$this->viewsPath}/{$this->model_name_as_kebab}-index.blade.php";

        $content = $this->parseContent(File::get($this->stubsPath . '/views/main.stub'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createFormComponent(): Generator
    {

        $destinationPath = "{$this->mainFolderPath}/{$this->modelName}Form.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/classes/form.stub'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->mainFolderPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createFormView(): Generator
    {
        $destinationPath = "{$this->viewsPath}/{$this->model_name_as_kebab}-form.blade.php";

        $content = $this->parseContent(File::get($this->stubsPath . '/views/form.stub'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createDetailComponent(): Generator
    {

        $destinationPath = "{$this->mainFolderPath}/{$this->modelName}Detail.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/classes/detail.stub'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->mainFolderPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createDetailView(): Generator
    {
        $destinationPath = "{$this->viewsPath}/{$this->model_name_as_kebab}-detail.blade.php";

        $content = $this->parseContent(File::get($this->stubsPath . '/views/detail.stub'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle Icons stub.
     *
     * @return Generator
     */
    protected function handleCopyIcons(): Generator
    {
        File::copyDirectory($this->stubsPath . '/../icons', resource_path('/views/livewire/icons'));

        return $this;
    }
    /**
     * Create the file on the given path with the string content
     *
     * @param string $destinationPath
     * @param string $content
     * @return Generator
     */
    protected function createFile(string $destinationPath, string $content, bool $warnFileExists = true, string $destinationDir): Generator
    {
        if (File::exists($destinationPath)) {
            if (!$this->force) {
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

    protected function warn($message)
    {
        $this->warns[] = $message;
    }

    protected function info($message)
    {
        $this->infos[] = $message;
    }

    protected function parseContent($content)
    {
        // $content = str_replace('[component-name]', $this->componentName, $content);
        // $content = str_replace('[component-name-kebab]', Str::kebab($this->componentName), $content);
        $content = str_replace('[model]', $this->modelName, $content);
        $content = str_replace('[models-path]', $this->modelsDir, $content);
        $content = str_replace('[model-plural]', $this->getModelNameAsplural(), $content);
        $content = str_replace('[model-snake]', $this->getModelNameAsSnake(), $content);
        $content = str_replace('[model-snake-plural]', $this->getModelNameAsPluralSnake(), $content);

        return $content;
    }

    protected function setStubsPath(string $path = null)
    {
        $this->stubsPath = $path ?: __DIR__ . '/../../stubs/' . Str::snake(class_basename($this));
    }

    public function getModelName()
    {
        return $this->modelName;
    }

    public function getModelNameAsplural()
    {
        return $this->model_name_as_plural;
    }

    public function getModelNameAsSnake()
    {
        return $this->model_name_as_snake;
    }

    public function getModelNameAsPluralSnake()
    {
        return $this->model_name_as_plural_snake;
    }
}
