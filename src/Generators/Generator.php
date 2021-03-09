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
    protected string $classesPath;
    /**
     * Override files if exists
     */
    protected bool $force;
    /**
     * The name of the component
     */
    protected string $componentName;
    /**
     * The name of the model to be used
     */
    protected string $modelName;
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
        string $componentName,
        string $modelName,
        bool $force = false,
        string $modelsDir = 'App\Models'
    ) {
        $this->viewsPath = resource_path('/views/livewire');

        $this->classesPath = app_path('/Http/Livewire');

        $this->componentName = $componentName;

        $this->modelName = $modelName;

        $this->force = $force;

        $this->modelsDir = $modelsDir;

        return $this->handlePaginationTrait()
            ->handleCopyIcons()
            ->createMainView()
            ->createMainComponent()
            ->createFormView()
            ->createFormComponent()
            ->createDetailView()
            ->createDetailComponent();
    }
    /**
     * Handle PaginationTrait stub.
     *
     * @return Generator
     */
    protected function handlePaginationTrait(): Generator
    {
        $destinationPath = $this->classesPath . '/PaginationTrait.php';

        $content = File::get($this->stubsPath . '/../pagination.stub');

        return $this->createFile($destinationPath, $content, $warnFileExists = false, $this->classesPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createMainView(): Generator
    {
        $kebabName = Str::kebab($this->componentName);
        $destinationPath = "{$this->viewsPath}/{$kebabName}.blade.php";

        $content = $this->parseContent(File::get($this->stubsPath . '/main.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createMainComponent(): Generator
    {
        $destinationPath = "{$this->classesPath}/{$this->componentName}.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/../main.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->classesPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createFormView(): Generator
    {
        $kebabName = Str::kebab($this->componentName);
        $destinationPath = "{$this->viewsPath}/{$kebabName}-form.blade.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/form.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createFormComponent(): Generator
    {
        $destinationPath = "{$this->classesPath}/{$this->componentName}Form.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/../form.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->classesPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createDetailView(): Generator
    {
        $kebabName = Str::kebab($this->componentName);
        $destinationPath = "{$this->viewsPath}/{$kebabName}-detail.blade.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/detail.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->viewsPath);
    }
    /**
     * Handle creating the view.
     *
     * @return Generator
     */
    protected function createDetailComponent(): Generator
    {
        $destinationPath = "{$this->classesPath}/{$this->componentName}Detail.php";
        $content = $this->parseContent(File::get($this->stubsPath . '/../detail.stub.'));

        return $this->createFile($destinationPath, $content, $warnFileExists = true, $this->classesPath);
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
        $content = str_replace('[component-name]', $this->componentName, $content);
        $content = str_replace('[component-name-kebab]', Str::kebab($this->componentName), $content);
        $content = str_replace('[model-plural]', Str::of($this->modelName)->studly()->plural(), $content);
        $content = str_replace('[model-snake-plural]', Str::of($this->modelName)->snake()->plural(), $content);
        $content = str_replace('[model-snake]', Str::snake($this->modelName), $content);
        $content = str_replace('[model]', $this->modelName, $content);
        $content = str_replace('[models-path]', $this->modelsDir, $content);

        return $content;
    }
}
