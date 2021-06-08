<?php

namespace Dainsys\LivewireGenerator\Tests\Feature;

use Dainsys\LivewireGenerator\Exceptions\MissingModelException;
use Dainsys\LivewireGenerator\Exceptions\MissingNameException;
use Dainsys\LivewireGenerator\Tests\TestCase;

class LivewireCrudPaginatedBootstrapTest extends TestCase
{
    /** @test */
    public function a_name_is_required()
    {
        $this->expectException(MissingNameException::class);

        $this->artisan('make:livewire-crud', ['name' => null, 'model' => 'Test', '--preset' => 'bootstrap'])
            ->expectsQuestion('Enter Component Name', null);
    }

    /** @test */
    public function a_model_is_required()
    {
        $this->expectException(MissingModelException::class);

        $this->artisan('make:livewire-crud', ['name' => 'test-component', 'model' => null, '--preset' => 'bootstrap'])
            ->expectsQuestion('Enter Model Name', null);
    }

    /** @test */
    public function it_copies_the_icons_stub()
    {
        $this->artisan('make:livewire-crud', ['name' => 'test-component', 'model' => 'Test', '--preset' => 'bootstrap']);

        $this->assertDirectoryExists($this->viewsDirectory . '/icons');
    }

    /** @test */
    public function it_creates_the_trait_file()
    {
        $this->artisan('make:livewire-crud', ['name' => 'test-component', 'model' => 'Test', '--preset' => 'bootstrap']);

        $this->assertFileExists($this->classesDirectory . '/PaginationTrait.php');
    }

    /** @test */
    public function it_creates_the_main_files()
    {
        $this->artisan('make:livewire-crud', ['name' => 'test-component', 'model' => 'Test', '--preset' => 'bootstrap']);

        $this->assertFileExists($this->classesDirectory . '/TestComponent.php');

        $this->assertFileExists($this->viewsDirectory . '/test-component.blade.php');
    }

    /** @test */
    public function it_creates_the_form_files()
    {
        $this->artisan('make:livewire-crud', ['name' => 'test-component', 'model' => 'Test', '--preset' => 'bootstrap']);

        $this->assertFileExists($this->classesDirectory . '/TestComponentForm.php');

        $this->assertFileExists($this->viewsDirectory . '/test-component-form.blade.php');
    }

    /** @test */
    public function it_creates_the_detail_files()
    {
        $this->artisan('make:livewire-crud', ['name' => 'test-component', 'model' => 'Test', '--preset' => 'bootstrap']);

        $this->assertFileExists($this->classesDirectory . '/TestComponentDetail.php');

        $this->assertFileExists($this->viewsDirectory . '/test-component-detail.blade.php');
    }
}