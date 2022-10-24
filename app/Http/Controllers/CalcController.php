<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\History;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalcController extends Controller
{
    /**
     * Calc salary and generate PDF document
     *
     * $employee_ids
     * $dates
     */
    public function calc(Request $request)
    {
        $request->validate([
            'dates' => 'required',
            'employee_ids' => 'required',
        ]);
        $data = $request->all();
        foreach($data['employee_ids'] as $employee_id) {
            foreach($data['dates'] as $date) {
                $dateFormatted= date('Y-m-d', strtotime($date));
                $row = DB::select(DB::raw('SELECT salaries.month_salary,
                    films.start_production_date,
                    films.end_production_date,
                    film_roles.role_id,
                    employee_film_roles.employee_id,
                    film_roles.id as f_role_id
                    FROM salaries
                        INNER JOIN employee_film_roles ON employee_film_roles.film_role_id = salaries.film_role_id
                        INNER JOIN film_roles ON film_roles.id = employee_film_roles.film_role_id
                        INNER JOIN films ON films.id = film_roles.film_id
                    WHERE employee_film_roles.employee_id = ' . $employee_id . ' AND films.start_production_date <= "' . $dateFormatted. '" and films.end_production_date >= "' . $dateFormatted. '";'));

                // if no payments for employee
                if(empty($row)) {
                    $row[] = (object) [
                        'employee_id' => $employee_id
                    ];
                }
                $result[] = (object) $row;
            }
        }
        $output = [];
        foreach($result as $item) {
            if(!empty($item)) {
                $itemData = reset($item);
                $historyInsert = false;
                foreach ($data['dates'] as $month) {
                    $employee = Employee::getById($itemData->employee_id);
                    $role = null;
                    if(property_exists($itemData, 'role_id')) {
                        $role = Role::getById($itemData->role_id);
                        if(!$historyInsert && date('Y-m-d', strtotime($month)) && $itemData->f_role_id) {
                            $row = [
                                'film_role_id' => $itemData->f_role_id,
                                'date' => date('Y-m-d', strtotime($month)),
                                'salary' => $itemData->month_salary
                            ];
                            History::updateOrCreate($row);
                            $historyInsert = true;
                        }
                    }
                    $output[] = [
                        'employee' => $employee && $employee['name'] ? $employee['name'] . ' ' . $employee['surname'] : 'Undefined employee',
                        'month'  => $month,
                        'role' => $role && $role['title'] ? $role['title'] : 'Undefined role',
                        'salary' => property_exists($itemData, 'month_salary') ? $itemData->month_salary : 'No payments'
                    ];
                }
            }
        }
        // generate PDF document
        $data = [
            'data' => $output
        ];
        $pdf = \PDF::loadView('salary.pdf', $data);
        return $pdf->download('salary_report.pdf');
    }
}
