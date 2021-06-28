<?php

namespace Dainsys\LivewireGenerator\Tests\Unit;

use Dainsys\LivewireGenerator\Exceptions\MissingModelException;
use Dainsys\LivewireGenerator\Tests\TestCase;

class LivewireGeneratorCommandTest extends TestCase
{
    /** @test */
    public function a_model_is_required()
    {
        $this->expectException(MissingModelException::class);

        $command = $this->artisan('make:livewire-crud', ['model' => null])
            ->expectsQuestion('Enter Model Name', null);
    }
}
