<div class="inline-flex">
    <!-- Tailwind Detail View -->
    {{-- // Show Details Modal --}}
    <x-jet-modal wire:model="show">
        <div class="align-middle flex items-center justify-between px-4">
            <h5 class="p-5 border-b sm:border-b-0 text-xl">
                {{ __('Details For') }} {{  __('[model]') }} {{ $[model-snake]->name ?? '' }}
            </h5> 
            <button wire:click.prevent="closeModal()" class="text-gray-3m00 hover:text-red-600 focus:outline-none self-center">
                <svg class="h-5 w-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>  
        </div>

        <div class="">
            {{-- Name --}}
            <dl>
                <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-t border-gray-200">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('Name') }}
                    </dt>
                    <dd class="mt-1 text-black font-bold sm:mt-0 sm:col-span-2">
                        {{ $[model-snake]->name ?? null }}
                    </dd>
                </div>
            </dl>           
           
        </div>

        <div class="p-3 bg-gray-100 flex justify-end">            
            <x-jet-secondary-button wire:click="closeModal()" class="text-dark bg-white">
                {{ __('Close') }}
            </x-jet-secondary-button>
        </div>
    </x-jet-modal>
</div>
