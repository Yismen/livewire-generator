<?php

namespace Dainsys\LivewireGenerator\Creators;

use Dainsys\LivewireGenerator\Generators\Generator;

class IndexClass extends BaseFileCreator
{
    protected string $stub_path = '/classes/main.stub';

    protected string $file_name_sufix = 'Index.php';

    protected string $file_model_name;

    protected bool $warn_file_exists = true;

    protected function getFileModelName()
    {
        return $this->generator->getModelName();
    }

    protected function getMainDestinationFolder()
    {
        return app_path('Http/Livewire/') .
            $this->file_model_name;
    }
}
