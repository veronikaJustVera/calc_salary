<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Salary extends Model
{
    use HasFactory;
    /**
     * Get salary for film_role
     */
    public static function getByFilmRole($film_id, $role_id) {
        return Salary::select('salaries.month_salary')
                ->join('film_roles', function($join) use($film_id, $role_id)
                {
                    $join->on('film_roles.id','=','salaries.film_role_id')
                        ->where('film_roles.film_id','=', $film_id)
                        ->where('film_roles.role_id','=', $role_id);
                })
                ->get();
    }
    public function calcByDateEmployee($employee_id, $date) {
        $dateFormatted = date('Y-m-d', strtotime($date));
        $row = DB::select('CALL get_salary_for_report(?,?);',array($employee_id, $dateFormatted));
        return !empty($row[0]) ? $row[0] : [];
    }
}
