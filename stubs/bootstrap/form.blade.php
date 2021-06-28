<div class="inline-flex">
    <button type="button" wire:click.prevent="create()"  data-toggle="modal" class="btn btn-primary">
        {{ __('Add') }}
    </button>  
    <!-- Create or Update Modal -->    
    <div wire:ignore.self class="modal fade" id="createOrUpdate[model]Modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title">
                        {{ $is_editing ? __('Edit') : __('Create') }} {{ __('[model]') }} {{ $fields['name'] ?? '' }}
                    </h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form 
                    @if ($is_editing)
                        wire:submit.prevent="update" wire:key="update_form"   
                    @else
                        wire:submit.prevent="store" wire:key="store_form"
                    @endif
                >                
                    <div class="modal-body">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6">                            
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text"
                                    class="form-control @error('fields.name') is-invalid @enderror" wire:model.debounce.350ms="fields.name" id="name" aria-describedby="name" placeholder="">
                                    @error('fields.name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>                          
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                        {{-- /Modal Body --}}
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-dark" data-dismiss="modal">{{ __('Close') }}</button> --}}
                        @if ($is_editing)                        
                            <button type="submit" class="btn btn-success">
                                {{  __('Update') }}
                            </button>
                        @else                      
                            <button type="submit" class="btn btn-primary">
                                {{  __('Create') }}
                            </button>                       
                        @endif
                    </div>
                </form>
                {{-- //Delete Button. Uncomment to enable deleting models --}}
                {{-- @if ($is_editing)                        
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-danger" wire:click.prevent="prepareDelete({{ $employee_photo->id }})">
                            {{  __('Delete') }}
                        </button> 
                    </div>                  
                @endif --}}
            </div>
        </div>
    </div>

    <!-- Delete Modal -->    
    <div wire:ignore.self class="modal fade" id="delete[model]Modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">{{ __('Delete') }} {{ __('[model]') }} {{ $fields['name'] ?? '' }}</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-danger">
                    {{ _('You are about to delete this record from the database, which CAN NOT be reverterd. Are you sure you want proceed?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-danger" wire:click.prevent="delete()">{{ __('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        document.addEventListener('open_[model-snake]_modal', () => {
            $('#createOrUpdate[model]Modal').modal('show');
        });
        
        document.addEventListener('close_[model-snake]_modal', () => {
            $('#createOrUpdate[model]Modal').modal('hide');
        });

        document.addEventListener('open_delete_[model-snake]_modal', () => {
            $('#delete[model]Modal').modal('show');
        });
        
        document.addEventListener('close_delete_[model-snake]_modal', () => {
            $('#delete[model]Modal').modal('hide');
        });
    })()
</script>
@endpush