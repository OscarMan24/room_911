<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        /* Validate that the user has permission to and enters the corresponding view */
        abort_if(Gate::denies('users.index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('panel.users.index');
    }
}
