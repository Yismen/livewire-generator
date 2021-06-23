<?php

namespace Dainsys\LivewireGenerator\Creators;

use Dainsys\LivewireGenerator\Generators\Generator;

interface FileCreatorContract
{
    public function __construct(Generator $generator);

    public function createFile();
}
