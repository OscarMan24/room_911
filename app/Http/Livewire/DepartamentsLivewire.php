<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Departamentos;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DepartamentsLivewire extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['borrado'];
    public $search = '', $search_status = '';
    public $name_departament;
    public $departament_id;
    public $readytoload = false;

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'search_status' => ['except' => '', 'as' => 'status'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];

    public function render()
    {
        return view('livewire.departaments-livewire');
    }

    public function loadData()
    {
        $this->readytoload = true;
    }

    public function store()
    {
        abort_if(Gate::denies('departments.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'name_departament' => 'required|string|max:120|min:2|unique:departamentos,name',
        ]);

        DB::beginTransaction();
        try {
            $departament = new Departamentos();
            $departament->name = $this->name_departament;
            $departament->status = 1;
            $departament->deleted = 0;
            $departament->save();
            $this->dispatchBrowserEvent('storeItem');
            $this->clean();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('departments.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->departament_id = $id;
        if ($this->Departamentt != '') {
            $this->name_departament = $this->Departamentt->name;
            $this->dispatchBrowserEvent('openEdit');
        } else {
            $this->dispatchBrowserEvent('errores', ['error' => __('An error has occurred, contact support')]);
        }
    }

    public function editItem()
    {
        abort_if(Gate::denies('departments.store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate([
            'name_departament' =>  ['required', 'string', Rule::unique('departamentos', 'name')->ignore($this->departament_id)],
        ]);

        DB::beginTransaction();
        try {
            $this->Departamentt->name = $this->name_departament;
            $this->Departamentt->update();
            $this->dispatchBrowserEvent('updatItem');
            $this->clean();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errores', ['error' => $e->getMessage()]);
        }
    }

    public function changestatus($id)
    {
        abort_if(Gate::denies('departments.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->departament_id = $id;
        if ($this->Departamentt != '') {
            if ($this->Departamentt->status == 1) {
                $this->Departamentt->Status = 0;
            } else {
                $this->Departamentt->status = 1;
            }
            $this->Departamentt->update();
            $this->dispatchBrowserEvent('statuschanged');
        }
    }

    public function borrar($id)
    {
        abort_if(Gate::denies('departments.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->departament_id = $id;
        $this->dispatchBrowserEvent('borrar');
    }

    public function borrado()
    {
        abort_if(Gate::denies('departments.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($this->Departamentt != '') {
            $this->Departamentt->deleted = 1;
            $this->Departamentt->update();
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

    public function clean()
    {
        $this->resetExcept(['search', 'search_status', 'readytoload']);
    }

    public function getDepartamentsProperty()
    {
        return Departamentos::where([
            ['name', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
        ])->orWhere([
            ['id', 'LIKE', '%' . $this->search . '%'], ['status', 'LIKE', '%' . $this->search_status], ['deleted', 0]
        ])->paginate(12);
    }

    public function getDepartamenttProperty()
    {
        return Departamentos::where([
            ['id', $this->departament_id], ['deleted', 0]
        ])->first();
    }
}
