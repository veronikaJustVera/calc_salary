<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
        unset($data['_token']);
        $data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');
        DB::table('roles')->insert($data);
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
