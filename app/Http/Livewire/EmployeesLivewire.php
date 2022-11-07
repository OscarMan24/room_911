<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Employee;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\Departamentos;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CreateNewsEmpleoyessImport;
use App\Models\EmployeeAccessRecord;
use Symfony\Component\HttpFoundation\Response;

class EmployeesLivewire extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['borrado'];
    public $search = '', $search_status = '', $search_departament = '', $search_initial, $search_end;
    public $employee_id;
    public $readytoload = false;
    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'search_status' => ['except' => '', 'as' => 'status'],
        'search_departament' => ['except' => '', 'as' => 'departament'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];

    public $name_employee, $last_name_employee, $departament_employee, $image, $image_current, $permission_empleoyee = 1;

    public $upload_file;

    public function render()
    {
        return view('livewire.employees-livewire');
    }

    public function loadData()
    {
        $this->readytoload = true;
    }

    public function store()
    {
        abort_if(Gate::denies('empleoye.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'name_employee' => 'required|min:2|max:120',
            'last_name_employee' => 'required|min:2|max:120',
            'departament_employee' => 'required|integer',
            'image' => 'nullable|image|max:5048|dimensions:width=1080,height=1080',
            'permission_empleoyee' => 'required|boolean'
        ]);

        DB::beginTransaction();
        try {
            $empleoyee = new Employee();
            $empleoyee->identifier = Str::upper(Str::random(10));
            $empleoyee->name = $this->name_employee;
            $empleoyee->last_name = $this->last_name_employee;
            if ($this->image) {
                $imgname2 = Str::slug(Str::limit($this->name_employee, 6, '')) . '-' . Str::random(4);
                $imageame2 = $imgname2 . '.' . $this->image->extension();
                $this->image->storeAs('empleoyees', $imageame2, 'public');
                $empleoyee->image = $imageame2;
            } else {
                $empleoyee->image = 'defaultuser.png';
            }
            $empleoyee->department_id = $this->departament_employee;
            $empleoyee->access_permission = $this->permission_empleoyee;
            $empleoyee->deleted = 0;
            $empleoyee->save();

            DB::commit();

            $this->dispatchBrowserEvent('storeItem');
            $this->clean();
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('empleoye.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->employee_id = $id;
        if ($this->Empleoyeee != '') {
            $this->name_employee = $this->Empleoyeee->name;
            $this->last_name_employee = $this->Empleoyeee->last_name;
            $this->departament_employee = $this->Empleoyeee->department_id;
            $this->image_current = $this->Empleoyeee->image;
            $this->permission_empleoyee = $this->Empleoyeee->access_permission;
            $this->dispatchBrowserEvent('openEdit');
        } else {
            $this->dispatchBrowserEvent('errores', ['error' => __('An error has occurred, contact support')]);
        }
    }

    public function editEmpleoyee()
    {
        abort_if(Gate::denies('empleoye.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'name_employee' => 'required|min:2|max:120',
            'last_name_employee' => 'required|min:2|max:120',
            'departament_employee' => 'required|integer',
            'image' => 'nullable|image|max:5048|dimensions:width=1080,height=1080',
            'permission_empleoyee' => 'required|boolean'
        ]);

        DB::beginTransaction();
        try {
            $this->Empleoyeee->name = $this->name_employee;
            $this->Empleoyeee->last_name = $this->last_name_employee;
            if ($this->image) {
                $imgname2 = Str::slug(Str::limit($this->name_employee, 6, '')) . '-' . Str::random(4);
                $imageame2 = $imgname2 . '.' . $this->image->extension();
                $this->image->storeAs('empleoyees', $imageame2, 'public');
                $this->Empleoyeee->image = $imageame2;
            }
            $this->Empleoyeee->department_id = $this->departament_employee;
            $this->Empleoyeee->access_permission = $this->permission_empleoyee;
            $this->Empleoyeee->update();
            DB::commit();
            $this->dispatchBrowserEvent('updatItem');
            $this->clean();
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function changestatus($id)
    {
        abort_if(Gate::denies('empleoye.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->employee_id = $id;
        if ($this->Empleoyeee != '') {
            if ($this->Empleoyeee->access_permission == 1) {
                $this->Empleoyeee->access_permission = 0;
            } else {
                $this->Empleoyeee->access_permission = 1;
            }
            $this->Empleoyeee->update();
            $this->dispatchBrowserEvent('statuschanged');
        }
    }

    public function borrar($id)
    {
        abort_if(Gate::denies('empleoye.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->employee_id = $id;
        $this->dispatchBrowserEvent('borrar');
    }

    public function borrado()
    {
        abort_if(Gate::denies('empleoye.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($this->Empleoyeee != '') {
            $this->Empleoyeee->deleted = 1;
            $this->Empleoyeee->update();
        }
    }

    public function updatedUploadFile()
    {
        $this->validate([
            'upload_file' => 'required|max:5000000|file'
        ]);
    }

    public function upoladEmpleo()
    {
        abort_if(Gate::denies('empleoye.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'upload_file' => 'required|max:5000000|file'
        ]);

        DB::beginTransaction();
        try {
            Excel::import(new CreateNewsEmpleoyessImport, $this->upload_file);
            DB::commit();
            $this->dispatchBrowserEvent('uploadItems');
            $this->clean();
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSearchStatus()
    {
        $this->resetPage();
    }

    public function updatedSearchDepartament()
    {
        $this->resetPage();
    }

    public function updatedSearchInitial()
    {
        $this->resetPage();
    }

    public function updatedSearchEnd()
    {
        $this->resetPage();
    }

    public function clean()
    {
        $this->resetExcept(['search', 'search_status', 'search_departament', 'readytoload']);
    }

    public function getEmpleoyeesProperty()
    {
        return Employee::with('departament:id,name')->where([
            ['name', 'LIKE', '%' . $this->search . '%'], ['access_permission', 'LIKE', '%' . $this->search_status], ['department_id', 'LIKE', '%' . $this->search_departament]
        ])->orWhere([
            ['last_name', 'LIKE', '%' . $this->search . '%'], ['access_permission', 'LIKE', '%' . $this->search_status], ['department_id', 'LIKE', '%' . $this->search_departament]
        ])->orWhere([
            ['id', 'LIKE', '%' . $this->search . '%'], ['access_permission', 'LIKE', '%' . $this->search_status], ['department_id', 'LIKE', '%' . $this->search_departament]
        ])->orWhere([
            ['identifier', 'LIKE', '%' . $this->search . '%'], ['access_permission', 'LIKE', '%' . $this->search_status], ['department_id', 'LIKE', '%' . $this->search_departament]
        ])->paginate(12);
    }

    public function getEmpleoyeeeProperty()
    {
        return Employee::where([
            ['id', $this->employee_id], ['deleted', 0]
        ])->first();
    }

    public function getDepartamentsProperty()
    {
        return Departamentos::where([
            ['status', 1], ['deleted', 0]
        ])->get();
    }
}
