<div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <a class="btn btn-primary" href="{{ route('index.employees') }}">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        {{ __('Access log of') . ' ' . $this->Empleoyeee->name . ' ' . $this->Empleoyeee->last_name }}
                    </h5>
                    <div class="row col-12 mb-4">
                        <div class="col-lg-3 col-md-4 col-12 mb-2">
                            <span>{{ __('Initial access date') }}</span>
                            <input type="date"
                                class="form-control @error('search_from') is-invalid @enderror"wire:model.debounce.500ms="search_from">
                            @error('search_from')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>

                        <div class="col-lg-3 col-md-4 col-12 mb-2">
                            <span>{{ __('Final access date') }}</span>
                            <input type="date"
                                class="form-control @error('search_to') is-invalid @enderror"wire:model.debounce.500ms="search_to">
                            @error('search_to')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>
                        <div class="col-lg-3 col-md-4 col-12 mb-2">
                            <br>
                            <button type="button" class="btn btn-success" wire:click="downloadRecords()">
                                <div wire:loading.inline wire:target="downloadRecords">
                                    <div class="spinner-grow spinner-grow-sm" role="status">
                                        <span class="sr-only">{{ __('Loading') }}...</span>
                                    </div>
                                </div>
                                <div wire:loading.remove wire:target="downloadRecords">
                                    <i class="fas fa-download"></i>
                                    {{ __('Download information pdf') }}
                                </div>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Date') }}</th>
                                    <th scope="col">{{ __('Access') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->Records as $record)
                                    <tr>
                                        <th scope="row">#{{ $record->id }}</th>
                                        <td>
                                            {{ $this->Empleoyeee->name . ' ' . $this->Empleoyeee->last_name }}
                                        </td>
                                        <td>{{ Carbon\Carbon::create($record->created_at)->isoFormat('LLLL') }}</td>

                                        <td>
                                            @if ($record->access_granted == 1)
                                                <span class="badge bg-success">{{ __('Access') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('No access') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        @can(['employees.edit', 'employees.delete'])
                                            <td colspan="4" class="text-center justify-content-center">
                                                ¡{{ __('No employees available') }}!
                                            </td>
                                        @else
                                            <td colspan="3" class="text-center justify-content-center">
                                                ¡{{ __('No employees available') }}!
                                            </td>
                                        @endcan

                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    @if (count($this->Records) > 0)
                        <div class="row text-center justify-content-center mt-2" style="max-width: 99%">
                            {{ $this->Records->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script>
        window.addEventListener('errores', event => {
            Swal.fire(
                '¡Error!',
                event.detail.error,
                'error'
            )
        })

        window.addEventListener('storeItem', event => {
            $('#createEmpleoyee').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has been created successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })

        window.addEventListener('openEdit', event => {
            $('#editEmpleoyee').modal('show');
        })

        window.addEventListener('updatItem', event => {
            $('#editEmpleoyee').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has been updated successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })

        window.addEventListener('statuschanged', event => {
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has successfully changed its access',
                showConfirmButton: false,
                timer: 1500
            })
        })
        window.addEventListener('uploadItems', event => {
            $('#uploadFile').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Sucess!',
                text: 'The item has been created successfully',
                showConfirmButton: false,
                timer: 1500
            })
        })
    </script>
</div>
