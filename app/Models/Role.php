<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public static function getListByFilm($filmId) {
        return Role::select('roles.id', 'roles.title')
                ->join('film_roles', function($join) use($filmId)
                {
                    $join->on('film_roles.role_id','=','roles.id')
                        ->where('film_roles.film_id','=', $filmId);
                })
                ->get();
    }
    public static function getList() {
        return Role::select('*')->get();
    }
    public static function getById($id) {
        return Role::find($id)->toArray();
    }
    public static function getTitleByFilmRoleId($filmRoleId) {
        $data = Role::select('roles.title')
                ->join('film_roles', function($join) use($filmRoleId)
                {
                    $join->on('film_roles.role_id','=','roles.id')
                        ->where('film_roles.id','=', $filmRoleId);
                })
                ->first()->toArray();
        return $data && $data['title'] ? $data['title'] : 'Unknown role';
    }
}
