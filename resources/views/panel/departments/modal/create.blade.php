<div class="modal fade" id="createdepartament" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create new department') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-12 mb-3">
                        <span>{{ __('Name') }}</span>
                        <input type="text" class="form-control @error('name_departament') is-invalid @enderror"
                            placeholder="{{ __('Departament name') }}" wire:model.defer="name_departament"
                            wire:target="store" wire:loading.attr="disabled">
                        @error('name_departament')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>
                    <div wire:loading wire:target="store">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                {{ __('Loading...') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" wire:target="store" wire:loading.attr="disabled"
                    data-bs-dismiss="modal" wire:click="clean()">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" wire:target="store" wire:loading.attr="disabled"
                    wire:click="store()">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
