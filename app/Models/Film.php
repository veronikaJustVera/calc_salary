<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PeriodTrait;

class Film extends Model
{
    use HasFactory;
    use PeriodTrait;
    /**
     * Properties
     */
    public $title;
    public $start_production_date;
    public $end_production_date;
    protected $fillable = ['title', 'start_production_date', 'end_production_date'];
    /**
     * Construct
     */
    function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
    /**
     * Get list
     */
    public static function getList() {
        return Film::select('*')->get();
    }
    /**
     * Get all production months
     */
    public function getAllDates() {
        $allFilms = Film::select('start_production_date', 'end_production_date')->get()->toArray();
        $months = $this->_parse_months_period($allFilms);
        return $months;
    }
}
