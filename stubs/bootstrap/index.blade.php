<div class="container mx-auto">
    <div class="card">
        <div class="card-body">
            <div class="align-items-baseline row">
                <div class="col-lg-4">
                    <h4 class="card-title">
                        {{ __('[model-plural]') }}
                        <span class="badge badge-dark">{{ $[model-snake-plural]->total() }}</span>
                    </h4>
                </div>
                <div class="col-lg-8">
                    <div class="d-flex justify-content-lg-end justify-content-start">
                        {{-- Pagination Amount --}}
                        <div class="mr-2">
                            {{-- <label for=""></label> --}}
                            <select class="form-control" wire:model="amount">
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
                        </div>
                        {{-- Search --}}
                        <div class="mr-2" wire:ignore>
                            <div class="input-group">
                                <input type="text"
                                class="form-control" wire:model.debounce.500ms="search" aria-describedby="helpId" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-light text-dark border" type="button" wire:click.prevent="$set('search', '')">&times;</button>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            @livewire('[model-name-kebab].[model-name-kebab]-form')
                            @livewire('[model-name-kebab].[model-name-kebab]-detail')
                        </div>
                    </div>
                </div>
                {{-- col --}}
            </div>
            {{-- .row --}}
        </div>
        {{-- car-body --}}
    </div>
    {{-- card --}}
    <div class="card mt-2">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover m-0">
                    <thead>
                        <tr>
                            <th>
                                <a href="#" wire:click.prevent="sortBy('name')" class="d-flex flex-row justify-content-between text-dark text-uppercase">
                                    {{ __('Name') }} 
                                    <span>{!! $this->getIcon('name') !!}</span>
                                </a>
                            </th>

                            <th class="col-2 col-lg-1">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($[model-snake-plural] as $[model-snake])
                            <tr>
                                <td>{{ $[model-snake]->name }}</td>

                                <td>
                                    <a href="#" class="btn btn-warning btn-sm" 
                                        wire:click.prevent="edit({{ $[model-snake]->id }})"
                                        title="{{ __('Edit') }}"
                                    >
                                        @include('livewire.icons.pencil')       
                                    </a>
                                    <a href="#" 
                                        class="btn btn-default btn-sm border" 
                                        wire:click.prevent="show({{ $[model-snake]->id }})"
                                        title="{{ __('Details') }}"
                                    >
                                        @include('livewire.icons.eye')                                         
                                    </a>                                    
                                </td>
                            </tr>
                        @endforeach          
                    </tbody>
                </table>
            </div>
        </div>
        
        @if ($[model-snake-plural]->hasPages())
            <div class="card-footer">            
                {{ $[model-snake-plural]->links() }}
            </div>
        @endif
    </div>
</div>
