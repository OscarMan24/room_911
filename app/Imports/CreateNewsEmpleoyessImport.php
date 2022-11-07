<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Str;
use App\Models\Departamentos;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class CreateNewsEmpleoyessImport implements ToModel
{
    public function model(array $row)
    {
        return new Employee([
            'identifier' => $row[0] != '' ? $row[0] : Str::upper(Str::random(8)),
            'name'    => $row[1],
            'last_name' => $row[2],
            'image' => 'defaultuser.png',
            'department_id' => $row[3] != '' ? Departamentos::where('id', $row[3])->orWhere('name', 'LIKE', '%' . $row[3] . '%')->first()->id : Departamentos::first()->id,
            'access_permission' => $row[4],
            'deleted' => 0
        ]);
    }
}
