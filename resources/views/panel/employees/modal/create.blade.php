<div class="modal fade" id="createEmpleoyee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create new employee') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-12 mb-3">
                        <span>{{ __('Name') }}</span>
                        <input type="text" class="form-control @error('name_employee') is-invalid @enderror"
                            placeholder="{{ __('Name') }}" wire:model.defer="name_employee" wire:target="store"
                            wire:loading.attr="disabled">
                        @error('name_employee')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <span>{{ __('Last name') }}</span>
                        <input type="text" class="form-control @error('last_name_employee') is-invalid @enderror"
                            placeholder="{{ __('Last name') }}" wire:model.defer="last_name_employee"
                            wire:target="store" wire:loading.attr="disabled">
                        @error('last_name_employee')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <span>{{ __('Departaments') }}</span>
                        <select class="form-control @error('departament_employee') is-invalid @enderror"
                            wire:model="departament_employee">
                            <option value="" selected>{{ __('Select an option') }}</option>
                            @foreach ($this->Departaments as $departament)
                                <option value="{{ $departament->id }}">{{ $departament->name }}</option>
                            @endforeach
                        </select>
                        @error('departament_employee')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <span>¿{{ __('Permission') }}?</span>
                        <select class="form-control @error('permission_empleoyee') is-invalid @enderror"
                            wire:model="permission_empleoyee">
                            <option value="" selected>{{ __('Select an option') }}</option>
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Disabled') }}</option>

                        </select>
                        @error('permission_empleoyee')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <span>{{ __('Empleoyee image') }} (1080 x 1080px)</span>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" accept="image/*"
                            wire:model="image" wire:target="store" wire:loading.attr="disabled">
                        @error('image')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror

                        <div wire:loading.inline wire:target="image">
                            <div class="col-12 my-1 text-center justify-content-center row">
                                <div class="spinner-grow my-2" role="status">
                                </div>
                            </div>
                        </div>

                        @if ($this->image)
                            <div class="col-12 mb-3 mt-3 text-center justify-content-center row">
                                <span>{{ __('Image preview') }}</span>
                                <img class="img-fluid " src="{{ $image->temporaryUrl() }}"
                                    style="max-width: 300px; border-radius:1rem">
                            </div>
                        @endif
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
