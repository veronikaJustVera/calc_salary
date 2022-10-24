<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\FilmRole;
use App\Models\Salary;


class SalaryController extends Controller
{
    /**
     * Edit salary
     */
    public function edit() {
        $films = Film::getList();
        return view('salary.edit',
        [
            'films' => $films
        ]);
    }
    /**
     * Save salary
     */
    public function save(Request $request) {
        $request->validate([
            'film_id' => 'required',
            'role_id' => 'required',
            'salary' => 'required',
        ]);
        $data = $request->all();
        $filmRoleId = FilmRole::getIdByFilmRole($data['film_id'], $data['role_id']);
        Salary::where('film_role_id', $filmRoleId)
            ->update(['month_salary' => $data['salary']]);
        return $this->backToMain('The salary was successfully updated');
    }
}
