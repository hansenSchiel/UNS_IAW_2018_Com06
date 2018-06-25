<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::resource('/','TorneoController');
Route::resource('equipo','EquipoController');
Route::resource('torneo','TorneoController');
Route::resource('encuentro','EncuentroController');
Route::resource('participacion','ParticipacionController');

Route::get('back/{id}',['uses'=>'TorneoController@back']);
Route::get('crearEjemplo',['uses'=>'TorneoController@crearEjemplo']);


Route::get('participar/{id}',['uses'=>'ParticipacionController@participar']);

Route::get('/redirect', 'SocialAuthTwitterController@redirect');
Route::get('/callback', 'SocialAuthTwitterController@callback');
Route::get('/logout', 'SocialAuthTwitterController@logout');

Route::get('/readme', 'GeneralController@readme');
Route::get('/user/{id}', 'GeneralController@show');