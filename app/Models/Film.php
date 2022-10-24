<?php

namespace App\Models;
use Carbon\CarbonPeriod;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    public static function getList() {
        return Film::select('*')->get();
    }
    /**
     * Get all production months
     */
    public static function getAllDates() {
        $months = [];
        $allFilms = Film::select('start_production_date', 'end_production_date')->get()->toArray();
        foreach($allFilms as $film) {
            foreach (CarbonPeriod::create($film['start_production_date'], '1 month', $film['end_production_date']) as $month) {
                $months[$month->format('Ym')] = $month->format('F Y');
            }
        }
        ksort($months);
        return $months;
    }
}
