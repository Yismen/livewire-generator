<?php

namespace Dainsys\LivewireGenerator\Creators;

use Dainsys\LivewireGenerator\Generators\Generator;
use Illuminate\Support\Facades\File;

class Icons extends BaseFileCreator
{
    protected string $stub_path = '../../pagination.stub';

    protected string $file_name_sufix = '';

    protected string $file_model_name;

    protected bool $warn_file_exists = true;

    protected function getFileModelName()
    {
        return $this->generator->getModelName();
    }

    protected function getMainDestinationFolder()
    {
        return app_path('Http/Livewire');
    }

    protected function getDestinationFileLocation()
    {
        return join("/", [
            $this->getMainDestinationFolder(),
            $this->file_name_sufix,
        ]);
    }

    public function createFile()
    {
        File::copyDirectory($this->generator->stubsPath . '/../icons', resource_path('/views/livewire/icons'));

        return $this;
    }
}
