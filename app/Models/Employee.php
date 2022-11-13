<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\PeriodTrait;

class Employee extends Model
{
    use HasFactory;
    use PeriodTrait;
    /**
     * Properties
     */
    public $name;
    public $surname;
    protected $fillable = ['name', 'surname'];
    /**
     * Construct
     */
    function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
    /**
     * List of all employees
     */
    public static function getList() {
        return Employee::select('*')->get();
    }
    /**
     * Get employee by id
     */
    public static function getById($id) {
        return Employee::find($id)->toArray();
    }
    /**
     * Get employee`s name by film_role_id
     */
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
    /**
     * Get work dates by employee id
     */
    public function getWorkDatesById($id) {
        $allFilms = Film::select('start_production_date', 'end_production_date')
                    ->join('film_roles', 'film_roles.film_id', '=', 'films.id')
                    ->join('employee_film_roles', 'employee_film_roles.film_role_id', '=', 'film_roles.id')
                    ->where('employee_film_roles.employee_id', '=', $id)
                    ->get()->toArray();

        $months = $this->_parse_months_period($allFilms);
        return json_encode($months);
    }
}
