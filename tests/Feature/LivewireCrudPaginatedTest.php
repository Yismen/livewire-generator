<?php

namespace Dainsys\LivewireGenerator\Tests\Feature;

use Dainsys\LivewireGenerator\Exceptions\MissingModelException;
use Dainsys\LivewireGenerator\Tests\TestCase;

class LivewireCrudPaginatedTest extends TestCase
{
    /** @test */
    public function a_model_is_required()
    {
        $this->expectException(MissingModelException::class);

        $this->artisan('make:livewire-crud', ['model' => null])
            ->expectsQuestion('Enter Model Name', null);
    }

    /** @test */
    public function it_copies_the_icons_stub()
    {
        $this->artisan('make:livewire-crud', ['model' => 'Test']);

        $this->assertDirectoryExists($this->viewsDirectory . '/icons');
        $this->assertFileExists($this->viewsDirectory . '/icons/asc.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/default.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/desc.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/eye.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/pencil.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/trash.blade.php');
    }

    /** @test */
    public function it_creates_the_trait_file()
    {
        $this->artisan('make:livewire-crud', ['model' => 'Test']);

        $this->assertFileExists($this->classesDirectory . '/PaginationTrait.php');
    }

    /** @test */
    public function it_creates_the_index_files()
    {
        $this->artisan('make:livewire-crud', ['model' => 'test']);

        $this->assertFileExists($this->classesDirectory . '/Test/TestIndex.php');

        $this->assertFileExists($this->viewsDirectory . '/test/test-index.blade.php');
    }

    /** @test */
    public function it_creates_the_form_files()
    {
        $this->artisan('make:livewire-crud', ['model' => 'test']);

        $this->assertFileExists($this->classesDirectory . '/Test/TestForm.php');

        $this->assertFileExists($this->viewsDirectory . '/test/test-form.blade.php');
    }

    /** @test */
    public function it_creates_the_detail_files()
    {
        $this->artisan('make:livewire-crud', ['model' => 'test']);

        $this->assertFileExists($this->classesDirectory . '/Test/TestDetail.php');

        $this->assertFileExists($this->viewsDirectory . '/test/test-detail.blade.php');
    }
}
