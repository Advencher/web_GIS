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
Route::get('/', function () {
    return view('welcome')->with('content','hello');
});
*/

Auth::routes();

/*ПИГМЕНТЫ--------------------------------------------------------------------*/
Route::post('/pigments_tab', function () {
    return view('pigments');
});

Route::get('/pigments', 'ViewNewPigmentsController@ShowAll');

Route::get('/pigmentsview', 'ViewNewPigmentsController@ShowAll2');

Route::get('/tropicCB', 'TrophicCharacterizationOfWaterController@ShowAllForComboBox');

Route::post('/delete_pigment', 'ViewNewPigmentsController@delete_pigment');

Route::post('/insert_pigment', 'ViewNewPigmentsController@insert_pigment');

Route::post('/update_pigment', 'ViewNewPigmentsController@update_pigment');

/*ПРОБЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫЫ*/

Route::get('/', function () {
    return view('main');
})->middleware('auth');

Route::post('/samples', function () {
    return view('samples');
});

Route::get('/samples_grid', 'ViewNewSamplesController@all');

Route::get('/filter', 'FilterController@data');

Route::get('/stationsCB', 'StationsController@allCB');

Route::post('/update_sample', 'ViewNewSamplesController@update_sample');

Route::post('/delete_sample', 'ViewNewSamplesController@delete_sample');

Route::post('/insert_sample', 'ViewNewSamplesController@insert_sample');

Route::get('/waterAreasCB', 'WaterAreaController@forComboBox');

Route::post('/insert_station', 'StationsController@insert_station');

Route::post('/stationInfo', 'ViewNewSamplesController@info');

/*АДМИННННННННННННННННННННННННННННННННННННННННННН*/

Route::get('/admin', function () {
    return view('admin');
})->middleware('can:create,App\Admin');//

Route::get('/rightsCB', 'RightController@allForCB')->middleware('can:create,App\Admin');

Route::get('/users', 'AdminController@all')->middleware('can:create,App\Admin');// в POST ?!?!?!?

Route::post('/update_user', 'AdminController@update_user');//Еcли POST, то проверяется токен https://laravel.ru/docs/v5/csrf

Route::post('/delete_user', 'AdminController@delete_user');

//фитопланктон

Route::post('/AllPhytos', function () {
    return view('Phytoplankton');
});

Route::get('/phytos1', 'ViewNewPhytos1Controller@ShowPhytos');

Route::get('/phyto_main', 'ViewNewPhytos1Controller@ShowPage');

Route::post('/update_phyto1', 'ViewNewPhytos1Controller@update_phyto1');

Route::post('/update_phyto2', 'ViewNewPhytos1Controller@update_phyto2');

Route::get('/horizonsCB', 'HorizonLevelsController@ShowAllForComboBox');

Route::get('/prep_delete', 'ViewNewPhytos1Controller@prep_delete');

Route::post('/delete_phyto1', 'ViewNewPhytos1Controller@delete_phyto1');

Route::post('/insert_phyto1', 'ViewNewPhytos1Controller@insert_phyto1');

Route::get('/maxIDPhyto', 'ViewNewPhytos1Controller@maxID');

Route::get('/waterPurityCB', 'ClassOfWaterPurityController@forComboBox');

Route::get('/saprobityCB', 'SaprobityController@forComboBox');

Route::get('/search1', 'PhytoSearchController@search1');

Route::post('/showPageSpGp', 'ViewNewPhytosSpeciesAndGroupsController@ShowPageSpGp');

Route::get('/phytosSP', 'ViewNewPhytosSpeciesAndGroupsController@ShowPhytosSpecies');

Route::get('/phytosGP', 'ViewNewPhytosSpeciesAndGroupsController@ShowPhytosGroups');

Route::get('/speciesCB', 'SpGpOfPhytoplanktonController@ShowAllForComboBoxSp');

Route::get('/groupsCB', 'SpGpOfPhytoplanktonController@ShowAllForComboBoxGp');

Route::post('/update_species', 'ViewNewPhytosSpeciesAndGroupsController@update_species_in_phyto_sample');

Route::post('/insert_species', 'ViewNewPhytosSpeciesAndGroupsController@insert_species_in_phyto_sample');

Route::post('/delete_species', 'ViewNewPhytosSpeciesAndGroupsController@delete_species_in_phyto_sample');

Route::get('/maxIDSpecie', 'ViewNewPhytosSpeciesAndGroupsController@maxIDSpecies');

Route::post('/speciesInfo', 'SpeciesOfPhytoplanktonController@speciesInfo');

Route::post('/update_groups', 'ViewNewPhytosSpeciesAndGroupsController@update_group_in_phyto_sample');

Route::post('/insert_groups', 'ViewNewPhytosSpeciesAndGroupsController@insert_group_in_phyto_sample');

Route::post('/delete_groups', 'ViewNewPhytosSpeciesAndGroupsController@delete_group_in_phyto_sample');

Route::get('/maxIDGroup', 'ViewNewPhytosSpeciesAndGroupsController@maxIDGroups');

Route::post('/insertNewSpecie', 'SpeciesOfPhytoplanktonController@insertNewSpecie');

Route::get('/groupsDialogItems', 'GroupsOfPhytoplanktonController@forComboBox');

Route::get('/showOnePhytoSample', 'ViewNewPhytos1Controller@ShowOnePhyto');

Route::get('/onePhytoMain', function () {
    return view('onePhytoMain');
})->middleware('auth');











