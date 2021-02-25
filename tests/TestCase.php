<?php

namespace Dainsys\LivewireGenerator\Tests;

use Dainsys\LivewireGenerator\LivewireGeneratorServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    /**
     * The directory for the views
     */
    protected string $viewsDirectory;
    /**
     * The directory for the classes
     */
    protected string $classesDirectory;

    /**
     * Executed before each test.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->viewsDirectory = resource_path('views/livewire');
        $this->classesDirectory = app_path('Http/Livewire');
    }

    /**
     * Executed after each test.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        $this->deleteTempFiles();
    }

    /**
     * Load the command service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            LivewireGeneratorServiceProvider::class
        ];
    }

    /**
     * Delete all fake log files int the test temporary directory.
     */
    private function deleteTempFiles(): void
    {
        // Remove all files in views directory
        foreach (glob($this->viewsDirectory . '/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        // Remove all files on incones directory
        foreach (glob($this->viewsDirectory . '/icons/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        // Remove icon directory
        if (is_dir($this->viewsDirectory . '/icons')) {
            rmdir($this->viewsDirectory . '/icons');
        };
        // Remove views directory
        if (is_dir($this->viewsDirectory)) {
            rmdir($this->viewsDirectory);
        };
        // Remove all files in Livewire directory
        foreach (glob($this->classesDirectory . '/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        // Remove Livewire directory
        if (is_dir($this->classesDirectory)) {
            rmdir($this->classesDirectory);
        }
    }
}
