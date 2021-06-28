<?php

namespace App\Http\Livewire\[model];

use App\Http\Livewire\PaginationTrait;
use [models-path]\[model];
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class [model]Index extends Component
{
    use PaginationTrait;
    use AuthorizesRequests;
    /**
     * Event Listeners
     *
     * @var array
     */
    protected $listeners = ['[model-snake]Saved' => '$refresh'];
    /**
     * Render the view when variables are updated.
     *
     * @return void
     */
    public function render()
    {
        $this->authorize('viewAny', [model]::class);

        // $this->defaultSortField = 'first_name'; 

        return view('livewire.[model-name-kebab].[model-name-kebab]-index', [
            '[model-snake-plural]' => $this->getPaginatedData(
                $query = [model]::query(),
                $searchableFields =  [
                    'name',
                ]
            )
        ]);
    }

    public function create()
    {
        $this->emit('wantsCreate[model]');
    }

    public function edit([model] $[model-snake])
    {
        $this->emit('wantsEdit[model]', $[model-snake]);
    }

    public function delete([model] $[model-snake])
    {
        $this->emit('wantsDelete[model]', $[model-snake]);
    }

    public function show([model] $[model-snake])
    {
        $this->emit('wantsShow[model]', $[model-snake]);
    }
}
