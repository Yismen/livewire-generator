<?php

namespace Dainsys\LivewireGenerator\Tests\Feature;

use Dainsys\LivewireGenerator\Exceptions\MissingModelException;
use Dainsys\LivewireGenerator\Tests\TestCase;

class LivewireCrudPaginatedBootstrapTest extends TestCase
{
    /** @test */
    public function a_model_is_required()
    {
        $this->expectException(MissingModelException::class);

        $this->artisan('make:livewire-crud', ['model' => null, '--preset' => 'bootstrap'])
            ->expectsQuestion('Enter Model Name', null);
    }

    /** @test */
    public function it_copies_the_icons_stub()
    {
        $this->artisan('make:livewire-crud', ['model' => 'Test', '--preset' => 'bootstrap']);
        // Icons
        $this->assertDirectoryExists($this->viewsDirectory . '/icons');
        // $this->assertFileExists($this->viewsDirectory . '/icons/asc.blade.php');
        // $this->assertFileExists($this->viewsDirectory . '/icons/default.blade.php');
        // $this->assertFileExists($this->viewsDirectory . '/icons/desc.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/eye.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/pencil.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/trash.blade.php');
        // Pagination Trait
        $this->assertFileExists($this->classesDirectory . '/PaginationTrait.php');
        // Index Class
        $this->assertFileExists($this->classesDirectory . '/Test/TestIndex.php');
        // Index View
        $this->assertFileExists($this->viewsDirectory . '/test/test-index.blade.php');
        // Form Class
        $this->assertFileExists($this->classesDirectory . '/Test/TestForm.php');
        // Form View
        $this->assertFileExists($this->viewsDirectory . '/test/test-form.blade.php');
        // Detal Class
        $this->assertFileExists($this->classesDirectory . '/Test/TestDetail.php');
        // Detail View
        $this->assertFileExists($this->viewsDirectory . '/test/test-detail.blade.php');
    }
}
