<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'App\Http\Controllers\IndexController@show')->name('main');

Route::get('history', 'App\Http\Controllers\HistoryController@show')->name('history');

Route::post('calc_salary', 'App\Http\Controllers\CalcController@calc');

Route::match(['get', 'post'], 'salary/edit', 'App\Http\Controllers\SalaryController@edit')->name('salary_edit');
Route::match(['get', 'post'], 'salary/save', 'App\Http\Controllers\SalaryController@save')->name('salary_save');


Route::match(['get', 'post'], 'role/add', 'App\Http\Controllers\RoleController@add')->name('role_add');
Route::match(['get', 'post'], 'role/save', 'App\Http\Controllers\RoleController@save')->name('role_save');
Route::match(['get', 'post'], 'role/get_for_film', 'App\Http\Controllers\RoleController@getForFilm')->name('role_get_for_film');
Route::match(['get', 'post'], 'role/get_salary', 'App\Http\Controllers\RoleController@getSalary')->name('role_get_salary');

Route::match(['get', 'post'], 'films', 'App\Http\Controllers\FilmController@list')->name('films');
Route::match(['get', 'post'], 'film/add', 'App\Http\Controllers\FilmController@add')->name('film_add');
Route::match(['get', 'post'], 'film/save', 'App\Http\Controllers\FilmController@save')->name('film_save');

Route::match(['get', 'post'], 'employees', 'App\Http\Controllers\EmployeeController@list')->name('employees');
Route::match(['get', 'post'], 'employee/add', 'App\Http\Controllers\EmployeeController@add')->name('employee_add');
Route::match(['get', 'post'], 'employee/save', 'App\Http\Controllers\EmployeeController@save')->name('employee_save');
Route::match(['get', 'post'], 'employee/select', 'App\Http\Controllers\EmployeeController@select')->name('employee_select');
Route::match(['get', 'post'], 'employee/addrole', 'App\Http\Controllers\EmployeeController@addrole')->name('employee_add_role');
Route::match(['get', 'post'], 'employee/saverole', 'App\Http\Controllers\EmployeeController@saverole')->name('employee_save_role');
