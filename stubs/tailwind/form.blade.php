<div class="inline-flex">
    <x-jet-button wire:click.prevent="create()">
        {{ __('Add') }}
    
    {{-- // Create or Update Modal --}}
    <x-jet-dialog-modal wire:model="show">
        <x-slot name="title">
            <div class="flex justify-between">
                @if ($is_editing)
                    {{ __('Edit') }} {{ __('[model]') }} {{ $[model-snake]->name }} 
                @else
                    {{ __('Create') }} {{ __('[model]') }}
                @endif 
                <button wire:click.prevent="closeModal()" type="button" class="text-gray-300 hover:text-red-600 focus:outline-none self-end">
                    <svg class="h-5 w-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </button>  
            </div>  
        </x-slot>
        <form 
            @if ($is_editing)
                wire:submit.prevent="update" wire:key="update_form"   
            @else
                wire:submit.prevent="store" wire:key="store_form"
            @endif
        >   
            <x-slot name="content">       
                <div class="flex flex-col">
                    <div class="md:flex">
                        <div class="w-full px-3 mb-3">
                            <x-jet-label>{{ __('Name') }}</x-jet-label>
                            <x-jet-input wire:model.debounce.500ms="fields.name" type="text" class="w-full"></x-jet-input>
                            <x-jet-input-error for="fields.name"></x-jet-input-error>
                        </div>
                    </div>
                    {{-- ./Row --}}
                </div>
            </x-slot>
            <x-slot name="footer">
                @if ($is_editing)
                    <x-jet-button type="submit" class="bg-green-800 hover:bg-green-700 active:bg-green-900 focus:border-green-900 px-2 py-1">
                        {{ __('Update') }}
                    </x-jet-button>
                @else
                    <x-jet-button type="submit">
                        {{ __('Create') }}
                    </x-jet-button>
                @endif
            </x-slot>
        </form>
        {{-- //Delete Button. Uncomment to enable deleting models --}}
        {{-- @if ($is_editing)
            <x-slot name="footer bg-gray-300">
                <div class="flex mt-4"> 
                    <x-jet-danger-button class="mr-1" wire:click.prevent="prepareDelete({{ $[model-snake] }})">
                        {{ __('Delete') }}
                    </x-jet-danger-button>
                </div>
            </x-slot>
        @endif --}}
    </x-jet-dialog-modal>

    {{-- // Delete Modal --}}
    <x-jet-confirmation-modal wire:model="deleteModal">
        <x-slot name="title">
            {{ __('Delete') }} {{ __('[model]') }} {{ $fields['name'] ?? '' }}
        </x-slot>
        <x-slot name="content">
            {{ _('You are about to delete this record from the database, which CAN NOT be reverterd. Are you sure you want proceed?') }}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeModal()" class="text-dark bg-white">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="delete()">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>  
</div>
