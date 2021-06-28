<?php

namespace Dainsys\LivewireGenerator\Tests\Unit;

use Illuminate\Support\Str;
use Dainsys\LivewireGenerator\Generators\Bootstrap;
use Dainsys\LivewireGenerator\Tests\TestCase;

class BootstrapGeneratorTest extends TestCase
{
    protected $model = 'Model';

    /** @test */
    public function it_parses_name_correctly()
    {
        $command = new Bootstrap($this->model);

        $this->assertEquals($this->model, $command->getModelName());
    }

    /** @test */
    public function it_parses_name_as_plural_correctly()
    {
        $command = new Bootstrap($this->model);
        $this->assertEquals(Str::plural($this->model), $command->getModelNameAsplural());
    }

    /** @test */
    public function it_parses_name_as_snake_correctly()
    {
        $command = new Bootstrap($this->model);

        $this->assertEquals(Str::snake($this->model), $command->getModelNameAsSnake());
    }

    /** @test */
    public function it_parses_name_as_plural_snake_correctly()
    {
        $command = new Bootstrap($this->model);

        $this->assertEquals(Str::of($this->model)->plural()->snake(), $command->getModelNameAsPluralSnake());
    }
}
