<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\FilmRole;
use App\Models\EmployeeFilmRole;
use App\Models\Film;
use App\Models\Role;
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
        return (new Employee())->getWorkDatesById($id);
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
        $employeeInstance = new Employee($data);
        $result = $employeeInstance->save();

        return $result ? $this->backToMain('The employee was successfully saved') : null;
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
        $filmRole = FilmRole::getIdByFilmRole($data['film_id'], $data['role_id']);

        if(!$filmRole) {
            $filmRoleInstance = new FilmRole($data);
            $filmRoleInstance->save();
            $data['film_role_id'] = DB::getPdo()->lastInsertId();
        } else {
            $data['film_role_id'] = $filmRole->toArray()['id'];
        }

        $employeeFilmRoleInstance = new EmployeeFilmRole($data);
        $employeeFilmRoleInstance->save();
        return $this->backToMain('Employee role was successfully saved');
    }
}
