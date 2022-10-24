<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Employee;
use App\Models\Film;

use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // table columns which is not usable in blades
    protected $ignoreBladeColumns = ['id', 'created_at', 'updated_at'];
    // formating table column names to input label
    protected function getInputNamesByColumns($inputNames) {
        $result = [];
        foreach($inputNames as $inputName) {
            $result[$inputName] = ucfirst(str_replace('_', ' ', $inputName));
        }
        return $result;
    }
    protected function backToMain($customMessage) {
        $data = [
            'customMessage'  => $customMessage,
            'employees' => Employee::getList(),
            'allDates' => Film::getAllDates(),
        ];

        return View::make('index')->with($data);
    }
}
