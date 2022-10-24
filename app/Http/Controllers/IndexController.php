<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Film;

class IndexController extends Controller
{
    /**
     * Main page
     */
    public function show()
    {
        $employees = Employee::getList();
        $allDates = Film::getAllDates();
        return view('index',
        [
            'employees' => $employees,
            'allDates' => $allDates,
        ]);
    }
}
