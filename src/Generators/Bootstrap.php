<?php

namespace Dainsys\LivewireGenerator\Generators;

use Illuminate\Support\Str;

class Bootstrap extends Generator
{
    /**
     * Stubs Path Location
     */
    public string $stubsPath;

    public function __construct(string $modelName, bool $force = false, string $modelsDir = 'App\Models')
    {
        parent::__construct($modelName, $force, $modelsDir);

        $this->stubsPath = __DIR__ . '/../../stubs/' . Str::snake(class_basename($this));
    }
}
