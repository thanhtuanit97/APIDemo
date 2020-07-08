<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResouce('/student', 'API\StudentController');
Route::get('/student','API\\StudentController@index')->name('home');
Route::get('/student/{id}', 'API\\StudentController@studentbyID')->name('studentbyID');
Route::post('/student', 'API\\StudentController@store')->name('add_student');
Route::put('/student/{id}', 'API\\StudentController@update')->name('update_student');
Route::delete('/student/{id}', 'API\\StudentController@destroy')->name('delete_student');