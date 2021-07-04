<?php

namespace Dainsys\LivewireGenerator\Tests\Unit;

use Illuminate\Support\Str;
use Dainsys\LivewireGenerator\Generators\Tailwind;
use Dainsys\LivewireGenerator\Tests\TestCase;
use Illuminate\Support\Facades\File;

class TailwindGeneratorTest extends TestCase
{
    protected $model = 'Model';

    /** @test */
    public function it_parses_name_correctly()
    {
        $command = new Tailwind($this->model);

        $this->assertEquals($this->model, $command->getModelName());
    }

    /** @test */
    public function it_parses_name_as_plural_correctly()
    {
        $command = new Tailwind($this->model);
        $this->assertEquals(Str::plural($this->model), $command->getModelNameAsplural());
    }

    /** @test */
    public function it_parses_name_as_snake_correctly()
    {
        $command = new Tailwind($this->model);

        $this->assertEquals(Str::snake($this->model), $command->getModelNameAsSnake());
    }

    /** @test */
    public function it_parses_name_as_plural_snake_correctly()
    {
        $command = new Tailwind($this->model);

        $this->assertEquals(Str::of($this->model)->plural()->snake(), $command->getModelNameAsPluralSnake());
    }

    /** @test */
    public function form_view_contains_tailwind_reference()
    {
        $this->artisan('make:livewire-crud', ['model' => 'TestModel', '--preset' => 'tailwind']);

        $content = File::get($this->viewsDirectory . '/test-model/test-model-form.blade.php');

        $this->assertStringContainsString('Tailwind Form View', $content);
        $this->assertStringContainsString('Create or Update Modal', $content);
    }

    /** @test */
    public function index_view_contains_tailwind_reference()
    {
        $this->artisan('make:livewire-crud', ['model' => 'TestModel', '--preset' => 'tailwind']);

        $content = File::get($this->viewsDirectory . '/test-model/test-model-index.blade.php');

        $this->assertStringContainsString('Tailwind Index View', $content);
    }

    /** @test */
    public function detail_view_contains_tailwind_reference()
    {
        $this->artisan('make:livewire-crud', ['model' => 'TestModel', '--preset' => 'tailwind']);

        $content = File::get($this->viewsDirectory . '/test-model/test-model-detail.blade.php');

        $this->assertStringContainsString('Tailwind Detail View', $content);
    }
}
