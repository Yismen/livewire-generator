<?php

namespace Dainsys\LivewireGenerator\Tests\Feature;

use Dainsys\LivewireGenerator\Tests\TestCase;

class LivewireCrudPaginatedTest extends TestCase
{
    /** @test */
    public function it_generate_files_for_tailwind()
    {
        $this->artisan('make:livewire-crud', ['model' => 'TestModel', '--preset' => 'tailwind']);
        // Icons
        $this->assertDirectoryExists($this->viewsDirectory . '/icons');
        $this->assertFileExists($this->viewsDirectory . '/icons/eye.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/pencil.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/trash.blade.php');
        // Pagination Trait
        $this->assertFileExists($this->classesDirectory . '/PaginationTrait.php');
        // Index Class
        $this->assertFileExists($this->classesDirectory . '/TestModel/TestModelIndex.php');
        // Index View
        $this->assertFileExists($this->viewsDirectory . '/test-model/test-model-index.blade.php');
        // Form Class
        $this->assertFileExists($this->classesDirectory . '/TestModel/TestModelForm.php');
        // Form View
        $this->assertFileExists($this->viewsDirectory . '/test-model/test-model-form.blade.php');
        // Detal Class
        $this->assertFileExists($this->classesDirectory . '/TestModel/TestModelDetail.php');
        // Detail View
        $this->assertFileExists($this->viewsDirectory . '/test-model/test-model-detail.blade.php');
    }

    /** @test */
    public function it_generate_files_for_bootstrap()
    {
        $this->artisan('make:livewire-crud', ['model' => 'TestModel', '--preset' => 'bootstrap']);
        // Icons
        $this->assertDirectoryExists($this->viewsDirectory . '/icons');
        $this->assertFileExists($this->viewsDirectory . '/icons/eye.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/pencil.blade.php');
        $this->assertFileExists($this->viewsDirectory . '/icons/trash.blade.php');
        // Pagination Trait
        $this->assertFileExists($this->classesDirectory . '/PaginationTrait.php');
        // // Index Class
        $this->assertFileExists($this->classesDirectory . '/TestModel/TestModelIndex.php');
        // // Index View
        $this->assertFileExists($this->viewsDirectory . '/test-model/test-model-index.blade.php');
        // // Form Class
        $this->assertFileExists($this->classesDirectory . '/TestModel/TestModelForm.php');
        // // Form View
        $this->assertFileExists($this->viewsDirectory . '/test-model/test-model-form.blade.php');
        // // Detal Class
        $this->assertFileExists($this->classesDirectory . '/TestModel/TestModelDetail.php');
        // // Detail View
        $this->assertFileExists($this->viewsDirectory . '/test-model/test-model-detail.blade.php');
    }
}
