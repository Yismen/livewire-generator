<?php

namespace App\Http\Livewire\[model];

use [models-path]\[model];
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class [model]Form extends Component
{
    use AuthorizesRequests;
    /**
     * Add Event Listeners
     * 
     * @var array
     */
    protected $listeners = [
        'wantsCreate[model]' => 'create',
        'wantsEdit[model]' => 'edit',
        'wantsDelete[model]' => 'delete',
    ];
    /**
     * Display modal form
     */
    public bool $show = false;
    /**
     * Control delete modal
     */
    public bool $showDelete = false;
    /**
     * Control is editing status
     */
    public bool $is_editing = false;
    /**
     * Model Variable
     */
    public [model] $[model-snake];
    /**
     * Array of fields to serve as model
     */
    public array $fields = [
        'name',
    ];
    /**
     * Validation Rules
     */
    protected array $rules = [
        'fields.name' => 'required|min:3',
    ];
    /**
     * Customize validation error attributes
     */
    protected array $validationAttributes = [
        'fields.name' => 'name',
    ];
    /**
     * Component constructor method
     *
     * @param [model] $[model-snake]
     * @return void
     */
    public function mount([model] $[model-snake] = null)
    {
        $this->[model-snake] = $[model-snake];
    }
    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.[model-name-kebab].[model-name-kebab]-form');
    }
    /**
     * Display the create form.
     *
     * @return void
     */
    public function create()
    {
        $this->authorize('create', [model]::class);

        $this->resetValidation();
        $this->reset(['fields', 'is_editing', 'showDelete']);

        $this->openModal('open_[model-snake]_modal');
    }
    /**
     * Store the new model.
     *
     * @return void
     */
    public function store()
    {
        $this->authorize('create', [model]::class);
        $this->validate();

        [model]::create($this->fields);

        $this->emit('[model-snake]Saved');

        $this->closeModal('close_[model-snake]_modal');
    }
    /**
     * Display the edit form.
     *
     * @param [model] $[model-snake]
     * @return void
     */
    public function edit([model] $[model-snake])
    {
        $this->authorize('update', $[model-snake]);
        $this->resetValidation();
        $this->reset(['fields', 'is_editing', 'showDelete']);

        $this->fill(['is_editing' => true, 'fields' => $[model-snake]->toArray()]);

        $this->openModal('open_[model-snake]_modal');
    }
    /**
     * Update the current model.
     *
     * @return void
     */
    public function update()
    {
        $[model-snake] = [model]::findOrFail($this->fields['id']);
        $this->authorize('update', $[model-snake]);
        $this->validate();


        $[model-snake]->update($this->fields);

        $this->emit('[model-snake]Saved');

        $this->closeModal('close_[model-snake]_modal');
    }
    /**
     * Reset validation when variables are updated
     *
     * @param string $propertyName
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    /**
     * Display the delete modal.
     *
     * @param [model] $[model-snake]
     * @return void
     */
    public function prepareDelete([model] $[model-snake])
    {
        $this->authorize('delete', $[model-snake]);
        $this->reset(['showDelete', 'show']);

        $this->showDelete = true;
        $this->openModal('open_delete_employee_photo_modal');
    }
    /**
     * Delete current model.
     *
     * @param [model] $[model-snake]
     * @return void
     */
    public function delete()
    {
        $[model-snake] = [model]::findOrFail($this->fields['id']);
        $this->authorize('delete', $[model-snake]);
        $[model-snake]->delete();

        $this->emit('[model-snake]Saved');

        $this->closeModal('close_delete_[model-snake]_modal');
        $this->closeModal('close_[model-snake]_modal');
    }
    /**
     * P
     *
     * @param string $browser_event_name
     * @return void
     */ 
    public function openModal(string $browser_event_name = null)
    {
        $this->show = true;

        if ($browser_event_name) {
            $this->dispatchBrowserEvent($browser_event_name);
        }
    }
    /**
     * Close all modals
     *
     * @return void
     */
    public function closeModal(string $browser_event_name = null)
    {
        $this->resetValidation();
        $this->reset(['fields', 'is_editing', 'showDelete', 'show']);

        if ($browser_event_name) {
            $this->dispatchBrowserEvent($browser_event_name);
        }
    }
}
