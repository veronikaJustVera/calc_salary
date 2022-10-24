<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public static function getList() {
        return Employee::select('*')->get();
    }
    public static function getById($id) {
        return Employee::find($id)->toArray();
    }
    public static function getNameByFilmRoleId($filmRoleId) {
        $data = Employee::select('name', 'surname')
                ->join('employee_film_roles', function($join) use($filmRoleId)
                {
                    $join->on('employee_film_roles.employee_id','=','employees.id')
                        ->where('employee_film_roles.film_role_id','=', $filmRoleId);
                })
                ->first()->toArray();
        return $data['name'] && $data['surname'] ? $data['name'] . ' ' . $data['surname'] : 'Unknown';
    }
}
