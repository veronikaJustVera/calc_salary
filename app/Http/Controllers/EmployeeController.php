<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\FilmRole;
use App\Models\Film;
use App\Models\Role;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * List of employees
     */
    public function list() {
        return view('list', [
            'data' => Employee::getList()->toArray(),
            'title' => 'All employees',
            'columns' => ['name', 'surname']
        ]);
    }
    /**
     * Ajax method - get work dates by employee for select
     */
    public function select(Request $request) {
        $id = $request->id;
        $months = [];

        $allFilms = DB::select(DB::raw('SELECT films.start_production_date, films.end_production_date FROM films
                INNER JOIN film_roles ON film_roles.film_id = films.id
                INNER JOIN employee_film_roles ON employee_film_roles.film_role_id = film_roles.id
            WHERE employee_film_roles.employee_id = ' . $id));

        foreach($allFilms as $film) {
            foreach (CarbonPeriod::create($film->start_production_date, '1 month', $film->end_production_date) as $month) {
                $months[$month->format('Ym')] = $month->format('F Y');
            }
        }
        ksort($months);
        return json_encode($months);
    }
    /**
     * Add an employee
     */
    public function add() {
        $filmColumns = Schema::getColumnListing('employees');
        $inputNames = array_diff($filmColumns, $this->ignoreBladeColumns);
        $inputNames = $this->getInputNamesByColumns($inputNames);

        return view('add', [
            'columns' => $inputNames,
            'instance' => 'employee'
        ]);
    }
    /**
     * Save an employee
     */
    public function save(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
        ]);
        $data = $request->all();
        unset($data['_token']);
        DB::table('employees')->insert($data);
        return $this->backToMain('The employee was successfully saved');
    }
    /**
     * Add role for employee
     */
    public function addrole() {
        $employees = Employee::getList();
        $allRoles = Role::getList();
        $allFilms = Film::getList();
        return view('employee.add_role',
        [
            'employees' => $employees,
            'allRoles' => $allRoles,
            'allFilms' => $allFilms,
        ]);
    }
    /**
     * Save role for employee
     */
    public function saverole(Request $request) {
        $request->validate([
            'employee_id' => 'required',
            'film_id' => 'required',
            'role_id' => 'required',
        ]);
        $data = $request->all();
        unset($data['_token']);
        $filmRole = FilmRole::where([
            ['film_id', '=', $data['film_id']],
            ['role_id', '=', $data['role_id']],
        ])->first();
        if(!$filmRole) {
            DB::table('film_roles')->insert([
                'film_id' => $data['film_id'],
                'role_id' => $data['role_id']
            ]);
            $data['film_role_id'] = DB::getPdo()->lastInsertId();
        } else {
            $data['film_role_id'] = $filmRole->toArray()['id'];
        }
        unset($data['film_id']);
        unset($data['role_id']);
        DB::table('employee_film_roles')->insert($data);
        return $this->backToMain('Employee role was successfully saved');
    }
}
