<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
/*    
    return view('welcome');
*/
    //dd("ruta base");

Route::group(['prefix' => '/encuesta'], function(){

	Route::resource('encuestado', 'EncuestadoController');
	Route::resource('sector', 'SectorController');
	Route::resource('item', 'ItemController');
	Route::resource('respuesta', 'RespuestaController');
	Route::get('respuesta/{id}/{id2}/', 'RespuestaController@respuesta');

	Route::post('respuestamultiple','RespuestaMultipleController@store')->name('respuestamultiple');




});

/*    
    return view('welcome');

Route::group(['prefix' => '/encuesta'], function(){

	dd("ruta encuesta");
	Route::get('/encuestado', [
	'as' => 'encuestado.create',
	'uses' => 'EncuestadoController@create'
	]);

	Route::resource('encuestado', 'EncuestadoController');

});
*/

