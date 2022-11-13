<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use App\Models\Salary;

class RoleController extends Controller
{
    /**
     * Add a role
     */
    public function add() {
        $rolesColumns = Schema::getColumnListing('roles');
        $inputNames = array_diff($rolesColumns, $this->ignoreBladeColumns);
        $inputNames = $this->getInputNamesByColumns($inputNames);

        return view('add', [
            'columns' => $inputNames,
            'instance' => 'role'
        ]);
    }
    /**
     * Save role
     */
    public function save(Request $request) {
        $request->validate([
            'title' => 'required',
        ]);
        $data = $request->all();
        $roleInstance = new Role($data);
        $roleInstance->save();
        return $this->backToMain('The role was successfully saved');
    }
    /**
     * Ajax method - Get roles for film
     */
    public function getForFilm(Request $request) {
        return(Role::getListByFilm($request->id));
    }
    /**
     * Ajax method - Get salary by film and role
     */
    public function getSalary(Request $request) {
        return(Salary::getByFilmRole($request->film_id, $request->role_id));
    }
}
