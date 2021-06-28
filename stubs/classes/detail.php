<?php

namespace App\Http\Livewire\[model];

use [models-path]\[model];
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class [model]Detail extends Component
{
    use AuthorizesRequests;

    public bool $show = false;

    public [model] $[model-snake];

    protected $listeners = ['wantsShow[model]' => 'show'];

    public function render()
    {
        return view('livewire.[model-name-kebab].[model-name-kebab]-detail');
    }
    /**
     * Show model show.
     *
     * @param [model] $[model-snake]
     * @return void
     */
    public function show([model] $[model-snake])
    {
        $this->authorize('view', $[model-snake]);
        $this->[model-snake] = $[model-snake];

        $this->dispatchBrowserEvent('open_detail_[model-snake]_modal');
        $this->show = true;
    }
    /**
     * Close all modals
     *
     * @return void
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close_detail_[model-snake]_modal');
        $this->reset(['show']);
    }
}
