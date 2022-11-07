<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'identifier',
        'name',
        'last_name',
        'image',
        'department_id',
        'access_permission',
        'deleted'
    ];

    public function departament()
    {
        return $this->hasOne(Departamentos::class, 'id', 'department_id');
    }
}
