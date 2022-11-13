<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmRole extends Model
{
    use HasFactory;
    /**
     * Properties
     */
    public $film_id;
    public $role_id;
    protected $fillable = ['film_id', 'role_id'];
    /**
     * Construct
     */
    function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
    /**
     * Get id by film_id and role_id
     */
    public static function getIdByFilmRole($film_id, $role_id) {
        $result = FilmRole::select('id')
            ->where([
                ['film_id', '=', $film_id],
                ['role_id', '=', $role_id],
            ])
            ->get();
        return $result->toArray() && $result->toArray()[0]['id'] ? $result->toArray()[0]['id'] : null;
    }
}
