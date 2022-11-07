<div>
    <div class="authent-logo">
        <img src="{{ asset('/storage/public/' . \App\Models\Setting::find(1)->logo) }}" alt="">
    </div>
    <div class="authent-text">
        <p>{{ __('Welcome to') . ' ' . \App\Models\Setting::find(1)->app_name }} </p>
    </div>

    <div class="mb-4">
        <div class="form-floating">
            <input type="text" class="form-control @error('code_read') is-invalid @enderror"
                wire:model.defer="code_read" wire:keydown.enter="validationCode()">
            <label for="code_read">{{ __('Employee code') }}</label>
            @error('code_read')
                <div class="invalid-feedback ">{{ $message }} </div>
            @enderror
        </div>
    </div>

    <div wire:loading class="col-12">
        <div class="progress my-3">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100"
                aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                {{ __('Loading...') }}
            </div>
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-info m-b-xs" wire:click="validationCode()">
            <i class="fas fa-sign-in-alt"></i> {{ __('Access') }}
        </button>
    </div>

    <script>
        window.addEventListener('accessSuccess', event => {
            Swal.fire({
                icon: 'success',
                title: '!Access granted!',
                text: 'User has permission for this area',
                showConfirmButton: false,
                timer: 2500
            })
        })
        window.addEventListener('accessNotSuccess', event => {
            Swal.fire({
                icon: 'error',
                title: '¡No access!',
                text: 'The user does not have permission for this area',
                showConfirmButton: false,
                timer: 2500
            })
        })
        window.addEventListener('accessNotFound', event => {
            Swal.fire({
                icon: 'error',
                title: '¡No access!',
                text: 'The user has not been found',
                showConfirmButton: false,
                timer: 2500
            })
        })
    </script>
</div>
