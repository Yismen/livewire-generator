<?php

namespace Dainsys\LivewireGenerator\Generators;

class Tailwind extends Generator
{
    /**
     * Stubs Path Location
     */
    protected string $stubsPath;

    public function __construct(string $componentName, string $modelName, bool $force = false, string $modelsDir = 'App\Models')
    {
        parent::__construct($componentName, $modelName, $force, $modelsDir);

        $this->setStubsPath();
    }
}
