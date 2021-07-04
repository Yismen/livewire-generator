<?php

namespace Dainsys\LivewireGenerator\Creators;

use Dainsys\LivewireGenerator\Generators\Generator;

class Pagination extends BaseFileCreator
{
    protected string $stub_path = '../../pagination.php';

    protected string $file_name_sufix = 'PaginationTrait.php';

    protected string $file_model_name;

    protected bool $warn_file_exists = false;

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
}
