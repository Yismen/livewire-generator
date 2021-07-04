<div class="inline-flex" wire:ignore.self>
    <!-- Bootstrap Detail View -->
    <!-- Modal -->
    <div class="modal fade" id="detail[model]Modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('Details For') }} {{  __('[model]') }} {{ $[model-snake]->name ?? '' }}
                    </h5>
                    <button type="button" class="close" wire:click.prevent="closeModal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th class="col-4">{{ __('Name') }}</th>
                                <td>{{ $[model-snake]->name ?? '' }}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click.prevent="closeModal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>            
        (function() {
            window.addEventListener('open_detail_[model-snake]_modal', event => {
                $('#detail[model]Modal').modal('show');
            });
            
            window.addEventListener('close_detail_[model-snake]_modal', event => {
                $('#detail[model]Modal').modal('hide');
            });
        })();
    </script>
@endpush
