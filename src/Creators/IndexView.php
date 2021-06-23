<?php

namespace Dainsys\LivewireGenerator\Creators;

use Dainsys\LivewireGenerator\Generators\Generator;

class IndexView extends BaseFileCreator
{
    protected string $stub_path = '/views/main.stub';

    protected string $file_name_sufix = '-index.blade.php';

    protected string $file_model_name;

    protected bool $warn_file_exists = true;

    protected function getFileModelName()
    {
        return $this->generator->getModelNameAsKebab();
    }

    protected function getMainDestinationFolder()
    {
        return resource_path('views/livewire/') .
            $this->file_model_name;
    }
}
