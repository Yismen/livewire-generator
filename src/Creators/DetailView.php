<?php

namespace Dainsys\LivewireGenerator\Creators;

use Illuminate\Support\Str;

class DetailView extends BaseFileCreator
{
    protected string $stub_path = '/detail.blade.php';

    protected string $file_name_sufix = '-detail.blade.php';

    protected string $file_model_name;

    protected bool $warn_file_exists = true;

    protected function getFileModelName()
    {
        return $this->generator->getModelNameAsKebab();
    }

    protected function getMainDestinationFolder()
    {
        return resource_path('views/livewire/') .
            Str::of($this->file_model_name)->camel()->kebab();
    }
}
