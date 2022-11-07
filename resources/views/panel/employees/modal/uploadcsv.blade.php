<div class="modal fade" id="uploadFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Upload empleoyees') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-12 mb-3">
                        <span>{{ __('Upload your .csv or excel file') }}</span>
                        <input type="file" class="form-control @error('upload_file') is-invalid @enderror"
                            placeholder="{{ __('Name') }}" wire:model="upload_file" wire:target="upoladEmpleo"
                            wire:loading.attr="disabled" accept=".csv,.xlsx">
                        @error('upload_file')
                            <div class="invalid-feedback ">{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="col-md-4 col-12 mb-3">
                        <span>{{ __('File example') }}</span><br>
                        <a href="{{ asset('storage/public/file.csv') }}" target="_black"
                            class="btn btn-info">{{ __('Download') }}</a>
                    </div>

                    <div wire:loading wire:target="upoladEmpleo,upload_file">
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
                <button type="button" class="btn btn-danger" wire:target="upoladEmpleo" wire:loading.attr="disabled"
                    data-bs-dismiss="modal" wire:click="clean()">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" wire:target="upoladEmpleo" wire:loading.attr="disabled"
                    wire:click="upoladEmpleo()">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
