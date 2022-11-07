<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAccessLogsNotFound;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\EmployeeAccessRecord;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EmployeeAccessRecordController extends Controller
{
    public function index()
    {
        return view('empleoyeeaccess');
    }

    public function downloadRecord($from, $to, $id)
    {
        $employee = Employee::find($id)->toArray();
        if ($from != 'all' && $to == 'all') {
            $info =  EmployeeAccessRecord::where('employee_id', $id)
                ->whereDate('created_at', '>=', $from)
                ->get()->toArray();
        } elseif ($from == 'all' && $to != 'all') {
            $info =  EmployeeAccessRecord::where('employee_id', $id)
                ->whereDate('created_at', '<=', $to)
                ->get()->toArray();
        } elseif ($from != 'all' && $to != 'all') {
            $info =  EmployeeAccessRecord::where('employee_id', $id)
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->get()->toArray();
        } else {
            $info =  EmployeeAccessRecord::where('employee_id', $id)->get()->toArray();
        }
        $pdf = Pdf::loadView('export.employeerecords', compact('info', 'employee', 'from', 'to'));
        return $pdf->download($employee['name'] . '-' . $employee['last_name'] . '.pdf');
    }

    public function downloadRecord2($from, $to)
    {
        if ($from != 'all' && $to == 'all') {
            $info =  EmployeeAccessRecord::with('employee:id,name,last_name')->whereDate('created_at', '>=', $from)
                ->get()->toArray();
        } elseif ($from == 'all' && $to != 'all') {
            $info =  EmployeeAccessRecord::with('employee:id,name,last_name')->whereDate('created_at', '<=', $to)
                ->get()->toArray();
        } elseif ($from != 'all' && $to != 'all') {
            $info =  EmployeeAccessRecord::with('employee:id,name,last_name')->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->get()->toArray();
        } else {
            $info =  EmployeeAccessRecord::with('employee:id,name,last_name')->where('id', '>', 0)->get()->toArray();
        }
        $pdf = Pdf::loadView('export.employeerecords2', compact('info'));
        return $pdf->download('all-employees.pdf');
    }

    public function downloadRecord3($from, $to)
    {
        if ($from != 'all' && $to == 'all') {
            $info =  EmployeeAccessLogsNotFound::whereDate('created_at', '>=', $from)
                ->get()->toArray();
        } elseif ($from == 'all' && $to != 'all') {
            $info =  EmployeeAccessLogsNotFound::whereDate('created_at', '<=', $to)
                ->get()->toArray();
        } elseif ($from != 'all' && $to != 'all') {
            $info =  EmployeeAccessLogsNotFound::whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->get()->toArray();
        } else {
            $info =  EmployeeAccessLogsNotFound::where('id', '>', 0)->get()->toArray();
        }
        $pdf = Pdf::loadView('export.employeerecords3', compact('info'));
        return $pdf->download('all-employees.pdf');
    }

    public function indexRecordHistory()
    {
        abort_if(Gate::denies('employees.index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('panel.recordhistory.index');
    }
}
