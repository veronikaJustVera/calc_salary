<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    /**
     * Properties
     */
    public $title;
    protected $fillable = ['title'];
    /**
     * Construct
     */
    function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
    /**
     * Get all roles for film
     */
    public static function getListByFilm($filmId) {
        return Role::select('roles.id', 'roles.title')
                ->join('film_roles', function($join) use($filmId)
                {
                    $join->on('film_roles.role_id','=','roles.id')
                        ->where('film_roles.film_id','=', $filmId);
                })->get();
    }
    /**
     * Get list
     */
    public static function getList() {
        return Role::select('*')->get();
    }
    /**
     * Get by id
     */
    public static function getById($id) {
        return Role::find($id)->toArray();
    }
    /**
     * Get role title by film_role_id
     */
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
