<?php

namespace App\Http\Livewire;

use App\Models\Setting;
use Livewire\Component;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;
use App\Models\EmployeeAccessRecord;

class EmployeeRecordsLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_from = '', $search_to = '';
    protected $queryString = [
        'search_from' => ['except' => '', 'as' => 'from'],
        'search_to' => ['except' => '', 'as' => 'to'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];
    public $employee_id;

    public function mount($id)
    {
        $this->employee_id = $id;
    }

    public function render()
    {
        return view('livewire.employee-records-livewire');
    }

    public function updatedSearchFrom()
    {
        $this->resetPage();
    }

    public function updatedSearchTo()
    {
        $this->resetPage();
    }

    public function downloadRecords()
    {
        $from = $this->search_from != '' ? $this->search_from : 'all';
        $to = $this->search_to != '' ? $this->search_to : 'all';
        return redirect()->route('index.employees.record.download', ['from' => urlencode($from), 'to' => urlencode($to), 'id' => $this->employee_id]);
    }
    public function getEmpleoyeeeProperty()
    {
        return Employee::with('departament')->where([
            ['id', $this->employee_id], ['deleted', 0]
        ])->first();
    }

    public function getRecordsProperty()
    {
        if ($this->search_from != '' && $this->search_to == '') {
            return EmployeeAccessRecord::where('employee_id', $this->employee_id)
                ->whereDate('created_at', '>=', $this->search_from)
                ->paginate(24);
        } elseif ($this->search_from == '' && $this->search_to != '') {
            return EmployeeAccessRecord::where('employee_id', $this->employee_id)
                ->whereDate('created_at', '<=', $this->search_to)
                ->paginate(24);
        } elseif ($this->search_from != '' && $this->search_to != '') {
            return EmployeeAccessRecord::where('employee_id', $this->employee_id)
                ->whereDate('created_at', '>=', $this->search_from)
                ->whereDate('created_at', '<=', $this->search_to)
                ->paginate(24);
        } else {
            return EmployeeAccessRecord::where('employee_id', $this->employee_id)->paginate(24);
        }
    }
}
