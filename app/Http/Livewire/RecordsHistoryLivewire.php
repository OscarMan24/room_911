<?php

namespace App\Http\Livewire;

use App\Models\EmployeeAccessLogsNotFound;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeeAccessRecord;

class RecordsHistoryLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_from = '', $search_to = '', $search_employees = 1;
    protected $queryString = [
        'search_from' => ['except' => '', 'as' => 'from'],
        'search_to' => ['except' => '', 'as' => 'to'],
        'search_employees' => ['except' => '', 'as' => 'employees'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];
    public $employee_id;

    public function render()
    {
        return view('livewire.records-history-livewire');
    }

    public function downloadRecords()
    {
        if ($this->search_employees == 1) {
            $from = $this->search_from != '' ? $this->search_from : 'all';
            $to = $this->search_to != '' ? $this->search_to : 'all';
            return redirect()->route('index.employees.history.download', ['from' => urlencode($from), 'to' => urlencode($to)]);
        } else {
            $from = $this->search_from != '' ? $this->search_from : 'all';
            $to = $this->search_to != '' ? $this->search_to : 'all';
            return redirect()->route('index.employees.history.notfound.download', ['from' => urlencode($from), 'to' => urlencode($to)]);
        }
    }

    public function updatedSearchFrom()
    {
        $this->resetPage();
    }

    public function updatedSearchTo()
    {
        $this->resetPage();
    }

    public function updatedSearchEmployees()
    {
        $this->resetPage();
    }

    public function getRecordsProperty()
    {
        if ($this->search_from != '' && $this->search_to == '') {
            return EmployeeAccessRecord::with('employee')->where('employee_id', 'LIKE', '%' . $this->employee_id)
                ->whereDate('created_at', '>=', $this->search_from)
                ->paginate(24);
        } elseif ($this->search_from == '' && $this->search_to != '') {
            return EmployeeAccessRecord::with('employee')->where('employee_id', 'LIKE', '%' . $this->employee_id)
                ->whereDate('created_at', '<=', $this->search_to)
                ->paginate(24);
        } elseif ($this->search_from != '' && $this->search_to != '') {
            return EmployeeAccessRecord::with('employee')->where('employee_id', 'LIKE', '%' . $this->employee_id)
                ->whereDate('created_at', '>=', $this->search_from)
                ->whereDate('created_at', '<=', $this->search_to)
                ->paginate(24);
        } else {
            return EmployeeAccessRecord::with('employee')->where('employee_id', 'LIKE', '%' . $this->employee_id)->paginate(24);
        }
    }

    public function getRecordsNotFoundProperty()
    {
        if ($this->search_from != '' && $this->search_to == '') {
            return EmployeeAccessLogsNotFound::whereDate('created_at', '>=', $this->search_from)
                ->paginate(24);
        } elseif ($this->search_from == '' && $this->search_to != '') {
            return EmployeeAccessLogsNotFound::whereDate('created_at', '<=', $this->search_to)
                ->paginate(24);
        } elseif ($this->search_from != '' && $this->search_to != '') {
            return EmployeeAccessLogsNotFound::whereDate('created_at', '>=', $this->search_from)
                ->whereDate('created_at', '<=', $this->search_to)
                ->paginate(24);
        } else {
            return EmployeeAccessLogsNotFound::where('id', '>', 0)->paginate(24);
        }
    }
}
