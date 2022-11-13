<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;

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
                // get salary
                $salaryInstance = new Salary();
                $row = $salaryInstance->calcByDateEmployee($employee_id, $date);
                $result[] = $row;
            }
        }
        return $this->_generate_PDFreport($result);
    }
    /**
     * Generate PDF document
     */
    private function _generate_PDFreport($data) {
        $PDFdata = [
            'data' => $data
        ];
        $pdf = \PDF::loadView('salary.pdf', $PDFdata);
        return $pdf->download('salary_report.pdf');

    }
}
