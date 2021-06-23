<?php

namespace Dainsys\LivewireGenerator\Creators;

use Dainsys\LivewireGenerator\Generators\Generator;

class DetailClass extends BaseFileCreator
{
    protected string $stub_path = '/classes/detail.stub';

    protected string $file_name_sufix = 'Detail.php';

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
