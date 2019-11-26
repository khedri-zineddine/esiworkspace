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
Route::post('/login','UserController@Login');
Route::post('/etudiant/add','EtudiantController@add');
Route::post('/etudiant/show','EtudiantController@show');
Route::post('/etudiant/mesnote','EtudiantController@mesnote');
Route::post('/enseignent/add','EnseignentController@add');
Route::post('/enseignent/addnote','EnseignentController@addnote');
Route::post('/module/add','ModuleController@add');
Route::post('/enseignent/list','EnseignentController@getlist');
Route::get('/module/getmodule','ModuleController@getmodule');
