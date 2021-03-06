<?php

namespace Dainsys\LivewireGenerator\Generators;

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

    protected array $creators = [
        \Dainsys\LivewireGenerator\Creators\Icons::class,
        \Dainsys\LivewireGenerator\Creators\Pagination::class,
        \Dainsys\LivewireGenerator\Creators\IndexClass::class,
        \Dainsys\LivewireGenerator\Creators\IndexView::class,
        \Dainsys\LivewireGenerator\Creators\FormClass::class,
        \Dainsys\LivewireGenerator\Creators\FormView::class,
        \Dainsys\LivewireGenerator\Creators\DetailClass::class,
        \Dainsys\LivewireGenerator\Creators\DetailView::class,
    ];

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
        foreach ($this->creators as $creator) {
            $creator = (new $creator($this))
                ->createFile();

            $this->warns[] = $creator->warns;
            $this->infos[] = $creator->infos;
        }
    }

    public function getModelName()
    {
        return $this->modelName;
    }

    public function getMainFolderPath()
    {
        return $this->mainFolderPath;
    }

    public function getModelsDir()
    {
        return $this->modelsDir;
    }

    public function getModelNameAsplural()
    {
        return $this->model_name_as_plural;
    }

    public function getModelNameAsSnake()
    {
        return $this->model_name_as_snake;
    }

    public function getModelNameAsKebab()
    {
        return Str::of($this->model_name_as_snake)->camel()->kebab();
    }

    public function getModelNameAsPluralSnake()
    {
        return $this->model_name_as_plural_snake;
    }

    public function getForce(): bool
    {
        return $this->force;
    }
}
