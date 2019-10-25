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
Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {
	Route::get('/home',	['uses' => 'HomeController@getHome', 'as' => 'home']);
	Route::get('/',	['uses' => 'HomeController@getHome', 'as' => 'home']);
	Route::get('perfil', ['uses' => 'PerfilsController@index', 'as' => 'profile']);
	Route::get('perfil/editar', ['uses' => 'PerfilsController@edit', 'as' => 'profile.edit']);
	Route::put('perfil/update/{id}', ['uses' => 'PerfilsController@update', 'as' => 'profile.update']);
	Route::post('perfil/uploadImage', ['uses' => 'PerfilsController@uploadImage', 'as' => 'profile.uploadImage']);

	//Admin
	Route::group(['middleware' => ['role:admin']], function () {
		//Socis
		Route::get('socis',	 ['uses' => 'SocisController@index', 'as' => 'socis']);
		Route::get('socis/getData', ['uses' => 'SocisController@getData', 'as' => 'socis.data']);
		Route::get('socis/detall/{id}', ['uses' => 'SocisController@show', 'as' => 'socis.show']);
		Route::get('socis/crear', ['uses' => 'SocisController@create', 'as' => 'socis.create']);
		Route::get('socis/crearSeccio', ['uses' => 'SocisController@createSection', 'as' => 'socis.createSection']);
		Route::post('socis/store', ['uses' => 'SocisController@store', 'as' => 'socis.store']);
		Route::post('socis/storeSeccio', ['uses' => 'SocisController@storeSection', 'as' => 'socis.storeSection']);
		Route::get('socis/editar/{id}', ['uses' => 'SocisController@edit', 'as' => 'socis.edit']);
		Route::put('socis/update/{id}', ['uses' => 'SocisController@update', 'as' => 'socis.update']);
		Route::post('socis/uploadImage', ['uses' => 'SocisController@uploadImage', 'as' => 'socis.uploadImage']);
		Route::post('socis/eliminar/{id}', ['uses' => 'SocisController@delete', 'as' => 'socis.delete']);
		Route::post('socis/baixa', ['uses' => 'SocisController@unregister', 'as' => 'socis.unregister']);
		Route::get('socis/unregisterMotive', ['uses' => 'SocisController@unregisterMotive', 'as' => 'socis.unregisterMotive']);
		Route::post('socis/reactivar/{id}', ['uses' => 'SocisController@reactivate', 'as' => 'socis.reactivate']);
		Route::get('socis/importar', ['uses' => 'SocisController@import', 'as' => 'socis.import']);
		Route::post('socis/importSocis', ['uses' => 'SocisController@importSocis', 'as' => 'socis.importSocis']);
		Route::get('socis/exportar', ['uses' => 'SocisController@export', 'as' => 'socis.export']);

		//Rols
		Route::get('rols', ['uses' => 'RolesController@index', 'as' => 'rols']);
		Route::get('rols/getData', ['uses' => 'RolesController@getData', 'as' => 'rols.data']);
		Route::get('rols/detall/{id}', ['uses' => 'RolesController@show', 'as' => 'rols.show']);
		Route::get('rols/crear', ['uses' => 'RolesController@create', 'as' => 'rols.create']);
		Route::post('rols/store', ['uses' => 'RolesController@store', 'as' => 'rols.update']);
		Route::get('rols/editar/{id}', ['uses' => 'RolesController@edit', 'as' => 'rols.edit']);
		Route::put('rols/update/{id}', ['uses' => 'RolesController@update', 'as' => 'rols.update']);
		Route::post('rols/eliminar/{id}', ['uses' => 'RolesController@delete', 'as' => 'rols.delete']);

		//Seccions
		Route::get('seccions', ['uses' => 'SectionsController@index', 'as' => 'sections']);
		Route::get('seccions/getData', ['uses' => 'SectionsController@getData', 'as' => 'sections.data']);
		Route::get('seccions/detall/{id}', ['uses' => 'SectionsController@show', 'as' => 'sections.show']);
		Route::get('seccions/crear', ['uses' => 'SectionsController@create', 'as' => 'sections.create']);
		Route::post('seccions/store', ['uses' => 'SectionsController@store', 'as' => 'sections.store']);		
		Route::post('seccions/eliminar/{id}', ['uses' => 'SectionsController@delete', 'as' => 'sections.delete']);

		//Promotors
		Route::get('promotors', ['uses' => 'PromotorController@index', 'as' => 'promotors']);
		Route::get('promotors/getData', ['uses' => 'PromotorController@getData', 'as' => 'promotors.data']);
		Route::get('promotors/detall/{id}', ['uses' => 'PromotorController@show', 'as' => 'promotors.show']);
		Route::get('promotors/crear', ['uses' => 'PromotorController@create', 'as' => 'promotors.create']);
		Route::post('promotors/store', ['uses' => 'PromotorController@store', 'as' => 'promotors.store']);
		Route::get('promotors/editar/{id}', ['uses' => 'PromotorController@edit', 'as' => 'promotors.edit']);
		Route::put('promotors/update/{id}', ['uses' => 'PromotorController@update', 'as' => 'promotors.update']);
		Route::post('promotors/eliminar/{id}', ['uses' => 'PromotorController@delete', 'as' => 'promotors.delete']);

		//Informes
		Route::get('informes',['uses'=>'InformsController@index','as' => 'informs']);
		Route::get('informes/llistaSocis',['uses'=>'InformsController@llistaSocis','as'=>'informs.llistaSocis']);
		Route::get('informes/socisMenors',['uses'=>'InformsController@llistaSocisMenorscatorze','as'=>'informs.socisMenors']);
		
	});


	Route::group(['middleware' => ['role:admin;colaborador']], function () {
		//Socis
		Route::get('perfilSeccio/{id}', ['uses' => 'SectionsController@editSection', 'as' => 'sections.editSection']);
		Route::get('seccions/getSocisNotInSection/{idSection}', ['uses' => 'SectionsController@socisNotInSection', 'as' => 'sections.notInSection']);
		Route::post('seccions/attachSocis/{id}', ['uses' => 'SectionsController@attachSocis', 'as' => 'sections.attachSocis']);
		Route::post('seccions/detachSoci', ['uses' => 'SectionsController@detachSoci', 'as' => 'sections.detachSoci']);		
		Route::get('seccions/editar/{id}', ['uses' => 'SectionsController@edit', 'as' => 'sections.edit']);
		Route::put('seccions/update/{id}', ['uses' => 'SectionsController@update', 'as' => 'sections.update']);
		
		//Activitats
		/*Route::get('activitats', ['uses' => 'ActivitatsController@index', 'as' => 'activitats']);
		Route::get('activitats/getData', ['uses' => 'ActivitatsController@getData', 'as' => 'activitats.data']);
		Route::get('activitats/detall/{id}', ['uses' => 'ActivitatsController@show', 'as' => 'activitats.show']);
		Route::get('activitats/crear', ['uses' => 'ActivitatsController@create', 'as' => 'activitats.create']);
		Route::post('activitats/store', ['uses' => 'ActivitatsController@store', 'as' => 'activitats.store']);
		Route::get('activitats/editar/{id}', ['uses' => 'ActivitatsController@edit', 'as' => 'activitats.edit']);
		Route::put('activitats/update/{id}', ['uses' => 'ActivitatsController@update', 'as' => 'activitats.update']);*/
	});


	Route::group(['middleware' => ['role:admin;promotor']], function () {
		//Promotors
		Route::get('promotors/editar/{id}', ['uses' => 'PromotorController@edit', 'as' => 'promotors.edit']);
	});	
});
