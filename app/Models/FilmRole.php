<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmRole extends Model
{
    use HasFactory;
    public static function getIdByFilmRole($film_id, $role_id) {
        $result = FilmRole::select('id')
            ->where([
                ['film_id', '=', $film_id],
                ['role_id', '=', $role_id],
            ])
            ->get();
        return $result->toArray()[0] && $result->toArray()[0]['id'] ? $result->toArray()[0]['id'] : null;
    }
}
