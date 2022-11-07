<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use App\Models\EmployeeAccessLogsNotFound;
use App\Models\EmployeeAccessRecord;
use Livewire\Component;

class AccessControlLivewire extends Component
{

    public $code_read;

    public function render()
    {
        return view('livewire.access-control-livewire');
    }

    public function updatedCodeRead()
    {
        $this->validate([
            'code_read' => 'required|string|max:50'
        ]);
        $this->validationCode();
    }

    public function validationCode()
    {
        $this->validate([
            'code_read' => 'required|string|max:50'
        ]);

        $employee = Employee::where('identifier', $this->code_read)->first();
        if (!empty($employee)) {
            if ($employee->access_permission == 1) {
                $this->dispatchBrowserEvent('accessSuccess');
                $log = new EmployeeAccessRecord();
                $log->employee_id = $employee->id;
                $log->access_granted  = 1;
                $log->save();
                $employee->count_access = $employee->count_access + 1;
                $employee->save();
            } else {
                $this->dispatchBrowserEvent('accessSuccess');
                $log = new EmployeeAccessRecord();
                $log->employee_id = $employee->id;
                $log->access_granted  = 0;
                $log->save();
            }
            $this->clean();
        } else {
            $log = new EmployeeAccessLogsNotFound();
            $log->read_code = $this->code_read;
            $log->save();
            $this->dispatchBrowserEvent('accessNotFound');
            $this->clean();
        }
    }

    public function clean()
    {
        $this->reset('code_read');
    }
}
