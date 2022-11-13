<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Film;
use App\Rules\CompareDateRule;

class FilmController extends Controller
{
    /**
     * Films list
     */
    public function list() {
        return view('list', [
            'data' => Film::getList()->toArray(),
            'title' => 'All films',
            'columns' => ['title', 'end_production_date', 'start_production_date']
        ]);
    }
    /**
     * Add a film
     */
    public function add() {
        $filmColumns = Schema::getColumnListing('films');
        $inputNames = array_diff($filmColumns, $this->ignoreBladeColumns);
        $inputNames = $this->getInputNamesByColumns($inputNames);

        return view('add', [
            'columns' => $inputNames,
            'instance' => 'film'
        ]);
    }
    /**
     * Save a film
     */
    public function save(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'start_production_date' => 'required',
            'end_production_date' => ["required", new CompareDateRule($request->get('start_production_date'))],
        ]);
        $data = $request->all();
        $data['start_production_date'] = $this->_format_date_to_DB($data['start_production_date']);
        $data['end_production_date'] = $this->_format_date_to_DB($data['end_production_date']);
        $filmInstance = new Film($data);
        $filmInstance->save();
        return $this->backToMain('The film was successfully saved');
    }

    private function _format_date_to_DB($stringDate) {
        return date('Y-m-d', strtotime($stringDate));
    }
}
