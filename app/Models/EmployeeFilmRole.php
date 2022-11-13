<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFilmRole extends Model
{
    use HasFactory;
    /**
     * Properties
     */
    public $employee_id;
    public $film_role_id;
    protected $fillable = ['employee_id', 'film_role_id'];
    /**
     * Construct
     */
    function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
}
