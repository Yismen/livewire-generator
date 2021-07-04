<div class="container mx-auto">
    <!-- Tailwind Index View -->
    <div class="bg-white max-w-7xl mx-auto shadow-md my-3">        
        <div class="border-b flex flex-col lg:flex-row items-center justify-content-between p-4">
            <div class="flex items-center justify-between lg:mr-2 lg:w-1/2 w-full">
                <h4 class="font-semibold text-xl text-gray-800 leading-tight p-3">
                    {{ __('[model-plural]') }}
                    <span class="bg-gray-800 font-bold p-2 py-1 rounded text-sm text-white">{{ $[model-snake-plural]->total() }}</span>
                </h4>
            </div>
            <div class="flex justify-between lg:ml-2 lg:mt-0 lg:w-1/2 mt-5 self-start w-full md:w-8/12">
                <select wire:model="amount" class="border-gray-300 py-2 rounded text-grey-darker">
                    @foreach ($this->filterAmounts($[model-snake-plural]->total()) as $interval)
                        <option value="{{ $interval }}">
                            @if ($loop->last)
                                {{ __('All') }}
                            @else
                                {{ $interval }}
                            @endif
                        </option>                        
                    @endforeach
                </select>
                <div class="flex justify-end  w-full relative mr-1">
                    <x-jet-input placeholder="Search" class="mr-0 border px-3 h-100 form-input lg:mr-2 w-full ml-3" wire:model.delay.750ms="search">
                    </x-jet-input>                    
                    @if (strlen($search) > 0)
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button wire:click="$set('search', '')" class="text-gray-300 hover:text-red-600 focus:outline-none">
                             <svg class="h-5 w-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>                    
                @livewire('[model-name-kebab].[model-name-kebab]-form')
                @livewire('[model-name-kebab].[model-name-kebab]-detail')
            </div>
        </div>
        <div class="min-w-full overflow-x-auto">
            <div class="inline-block min-w-full">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="font-medium text-gray-500 border-b border-black font-semibold px-5 py-3 text-left text-xs tracking-wider uppercase">
                                <a href="#" wire:click.prevent="sortBy('name')" class="flex flex-row justify-between items-center">
                                    {{ __('Name') }} 
                                    <span>{!! $this->getIcon('name') !!}</span>
                                </a>
                            </th>
        
                            <th class="border-b border-black font-medium font-semibold md:w-2/12 px-5 py-3 sm:w-3/12 text-gray-500 text-left text-xs tracking-wider uppercase w-4/12">                    
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($[model-snake-plural] as $[model-snake])
                            <tr>
                                <td class="px-4 py-1 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">{{ $[model-snake]->name }}</td>
                                
                                <td class="px-4 py-1 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                                    <div class="flex gap-1 whitespace-no-wrap">
                                        <x-jet-button 
                                            wire:click.prevent="edit({{ $[model-snake]->id }})" 
                                            class="bg-yellow-800 hover:bg-yellow-700 active:bg-yellow-900 focus:border-yellow-900 px-2 py-1" 
                                            title="{{ __('Edit') }}"
                                        >
                                            @include('livewire.icons.pencil')
                                        </x-jet-button>
        
                                        <x-jet-secondary-button 
                                            wire:click.prevent="show({{ $[model-snake]->id }})" 
                                            title="{{ __('Details') }}"
                                        >
                                            @include('livewire.icons.eye')
                                        </x-jet-secondary-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($[model-snake-plural]->hasPages())
        <div class="pb-4">
            {{ $[model-snake-plural]->links() }}
        </div>
    @endif

</div>
