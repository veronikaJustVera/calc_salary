<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Film;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Main page
     */
    public function show(Request $request)
    {
        $employees = Employee::getList();
        $allDates = (new Film())->getAllDates();
        return view('index',
        [
            'employees' => $employees,
            'allDates' => $allDates,
            'customMessage' => $request->get('customMessage') ? $request->get('customMessage') : null
        ]);
    }
}
