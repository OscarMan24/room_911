<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function index()
    {
        /* Validate that the user has permission to and enters the corresponding view */
        abort_if(Gate::denies('employees.index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('panel.employees.index');
    }

    public function indexRecord($id)
    {
        /* Validate that the user has permission to and enters the corresponding view */
        abort_if(Gate::denies('employees.index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('panel.employees.indexrecord', compact('id'));
    }
}
