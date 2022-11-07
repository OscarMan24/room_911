<div wire:init="loadData">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('All the employees') }}
                        @can('employees.store')
                            <button data-bs-toggle="modal" data-bs-target="#createEmpleoyee" class="btn btn-primary ml-2"
                                type="button" wire:click="clean()"><i class="fas fa-plus"></i></button>
                        @endcan
                    </h5>
                    <div class="row col-12 mb-4">
                        <div class="col-lg-2 col-md-4 col-12 mb-2">
                            <span>{{ __('Search employee') }}</span>
                            <input type="search" class="form-control @error('search') is-invalid @enderror"
                                placeholder="{{ __('Search departments by') . ' id, name...' }}" wire:model="search">
                            @error('search')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>

                        <div class="col-lg-2 col-md-4 col-12 mb-2">
                            <span>{{ __('Search permission') }}</span>
                            <select class="form-control @error('search_status') is-invalid @enderror"
                                wire:model="search_status">
                                <option value="" selected>{{ __('Select an option') }}</option>
                                <option value="1">{{ __('Access') }}</option>
                                <option value="0">{{ __('No access') }}</option>
                            </select>
                            @error('search_status')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>

                        <div class="col-lg-2 col-md-4 col-12 mb-2">
                            <span>{{ __('Initial access date') }}</span>
                            <input type="date"
                                class="form-control @error('search_initial') is-invalid @enderror"wire:model="search_initial">
                            @error('search_initial')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>

                        <div class="col-lg-2 col-md-4 col-12 mb-2">
                            <span>{{ __('Final access date') }}</span>
                            <input type="date"
                                class="form-control @error('search_end') is-invalid @enderror"wire:model="search_end">
                            @error('search_end')
                                <div class="invalid-feedback ">{{ $message }} </div>
                            @enderror
                        </div>
                        <div class="col-lg-2 col-md-4 col-12 mb-2">
                            <br>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#uploadFile"><i class="fas fa-file-upload"></i>
                                {{ __('Upload empleoyees') }}</button>
                        </div>
                        <div class="col-lg-2 col-md-4 col-12 mb-2">
                            <br>
                            <a class="btn btn-info" href="{{ route('index.employees.record.history') }}">
                                <i class="fas fa-history"></i> {{ __('Record access') }}
                            </a>
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
                                    <th scope="col">{{ __('Departament') }}</th>
                                    <th scope="col">{{ __('Access') }}</th>
                                    <th scope="col">{{ __('Total access') }}</th>
                                    @can(['employees.edit', 'employees.delete'])
                                        <th scope="col">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->Empleoyees as $employe)
                                    <tr>
                                        <th scope="row">#{{ $employe->identifier }}</th>
                                        <td>
                                            {{ $employe->name . ' ' . $employe->last_name }}
                                        </td>
                                        <td>{{ $employe->departament->name }}</td>
                                        <td>
                                            @if ($employe->access_permission == 1)
                                                <span class="badge bg-success">{{ __('Access') }}</span>
                                            @elseif($employe->access_permission == 0)
                                                <span class="badge bg-danger">{{ __('No access') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ number_format($employe->count_access, 0) }}
                                        </td>
                                        @can(['employees.edit', 'employees.delete'])
                                            <td>
                                                <div class="dropdown dropstart">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        wire:key="dropdownMenuButton-{{ $employe->id }}"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('index.employees.record', $employe->id) }}">
                                                                <i class="fas fa-history"></i> {{ __('Records') }}</a>
                                                        </li>
                                                        @can('employees.edit')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="edit({{ $employe->id }})"> <i
                                                                        class="fas fa-edit"></i> {{ __('Edit') }}</button>
                                                            </li>
                                                            <li><button class="dropdown-item"
                                                                    wire:click="changestatus({{ $employe->id }})"> <i
                                                                        class="fas fa-eye{{ $employe->status == 1 ? '-slash' : '' }} "></i>
                                                                    {{ $employe->status == 1 ? __('No access') : __('Access') }}</button>
                                                            </li>
                                                        @endcan

                                                        @can('employees.delete')
                                                            <li><button class="dropdown-item"
                                                                    wire:click="borrar({{ $employe->id }})"> <i
                                                                        class="fas fa-trash-alt"></i>
                                                                    {{ __('Deleted') }}</button></li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        @endcan

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
                    @if (count($this->Empleoyees) > 0)
                        <div class="row text-center justify-content-center mt-2" style="max-width: 99%">
                            {{ $this->Empleoyees->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($readytoload)
        @include('panel.employees.modal.create')
        @include('panel.employees.modal.edit')
        @include('panel.employees.modal.uploadcsv')
    @endif


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
        window.addEventListener('borrar', event => {
            Swal.fire({
                icon: 'question',
                title: "¿Are you sure?",
                text: "This action cannot be returned",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    window.livewire.emit('borrado')
                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: '¡Processing! ',
                        text: 'Wait a moment, it will be available soon',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    })
                }
            });
        });
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
