<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    protected $fillable = ['film_role_id', 'date', 'salary'];
    use HasFactory;
    public static function getList() {
        $historyRecords = History::select('*')->get()->toArray();
        foreach($historyRecords as $key => $record) {
            $historyRecords[$key]['employee'] = Employee::getNameByFilmRoleId($record['film_role_id']);
            $historyRecords[$key]['role'] = Role::getTitleByFilmRoleId($record['film_role_id']);
            $historyRecords[$key]['date'] = date('F Y', strtotime($record['date']));
        }
        return $historyRecords;
    }
}
