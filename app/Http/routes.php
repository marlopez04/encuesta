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

	Route::resource('estadistica', 'EstadisticaController');

/*
	Route::get('estadistica/sede',[
		'uses' => 'EstadisticaController@sede',
		'as'   => 'encuesta.estadistica.sede'
	]);
*/

	

});

Route::group(['prefix' => '/estadistica'], function
	(){

		Route::resource('/', 'EstadisticaController');
		//Route::get('demografico', 'EstadisticaController@demografico');

		Route::get('demografico',[
		'uses' => 'EstadisticaController@demografico',
		'as'   => 'estadistica.demografico'
		]);

		Route::get('injecciondemo',[
		'uses' => 'EstadisticaController@injecciondemo',
		'as'   => 'estadistica.injecciondemo'
		]);

		Route::get('favorabilidaddemografico',[
		'uses' => 'EstadisticaController@favorabilidaddemografico',
		'as'   => 'estadistica.favorabilidaddemografico'
		]);

		Route::get('injeccionfavorabilidaddemo',[
		'uses' => 'EstadisticaController@injeccionfavorabilidaddemo',
		'as'   => 'estadistica.injeccionfavorabilidaddemo'
		]);

		//Route::get('sede', 'EstadisticaController@sede');

		Route::get('sede',[
		'uses' => 'EstadisticaController@sede',
		'as'   => 'estadistica.sede'
		]);

		Route::get('torta', 'EstadisticaController@torta');

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

