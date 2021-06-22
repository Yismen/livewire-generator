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

        // Remove all files to assure tests are working properly
        $this->deleteFilesRecursevely($this->viewsDirectory . '/icons/');
        $this->deleteFilesRecursevely($this->viewsDirectory);
        $this->deleteFilesRecursevely($this->classesDirectory);
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
     * Removes all files on a given directory.
     *
     * @param string $dir
     * @return boolean
     */
    protected function deleteFilesRecursevely(string $dir): bool
    {
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));

            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? $this->deleteFilesRecursevely("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        }

        return false;
    }
}
