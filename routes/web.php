<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'VillesController@getVilles')->name('index');
Route::post('/', 'VillesController@postIndex')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@postHome')->name('home');

Route::get('/operation/vols', 'VolsController@getVols')->name('vols');
Route::post('/operation/vols', 'VolsController@postVols')->name('vols');

Route::get('/operation/paiement', 'PaiementController@getPaiement')->name('paiement');
Route::post('/operation/paiement', 'PaiementController@postPaiement')->name('paiement');

Route::get('/operation/recu', 'RecuController@getRecu')->name('recu');

Route::get('/operation/list_vols', 'ListeVolsController@getListeVols')->name('listVols');
Route::post('/operation/list_vols', 'ListeVolsController@postCancel')->name('listVols');

Route::get('/operation/cancal_flight', 'CancelFlightController@getCancelFlight')->name('cancelFlight');
Route::post('/operation/cancal_flight', 'CancelFlightController@postCancelFlight')->name('cancelFlight');

