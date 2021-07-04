<?php

namespace Dainsys\LivewireGenerator\Tests\Unit;

use Illuminate\Support\Str;
use Dainsys\LivewireGenerator\Generators\Bootstrap;
use Dainsys\LivewireGenerator\Tests\TestCase;
use Illuminate\Support\Facades\File;

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

    /** @test */
    public function form_view_contains_bootstrap_reference()
    {
        $this->artisan('make:livewire-crud', ['model' => 'TestModel', '--preset' => 'bootstrap']);

        $content = File::get($this->viewsDirectory . '/test-model/test-model-form.blade.php');

        $this->assertStringContainsString('Bootstrap Form View', $content);
        $this->assertStringContainsString('Create or Update Modal', $content);
    }

    /** @test */
    public function index_view_contains_bootstrap_reference()
    {
        $this->artisan('make:livewire-crud', ['model' => 'TestModel', '--preset' => 'bootstrap']);

        $content = File::get($this->viewsDirectory . '/test-model/test-model-index.blade.php');

        $this->assertStringContainsString('Bootstrap Index View', $content);
    }

    /** @test */
    public function detail_view_contains_bootstrap_reference()
    {
        $this->artisan('make:livewire-crud', ['model' => 'TestModel', '--preset' => 'bootstrap']);

        $content = File::get($this->viewsDirectory . '/test-model/test-model-detail.blade.php');

        $this->assertStringContainsString('Bootstrap Detail View', $content);
    }
}
