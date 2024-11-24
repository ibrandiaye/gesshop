<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FactureeController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RetourController;
use App\Http\Controllers\SortieController;
use App\Http\Controllers\TransfertController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */
Route::get('/',[DashboardController::class,'home'])->name('home');

Route::get('/detail/produit/{produit_id}',[DashboardController::class,'getProduitDepotById'])->name('detail.produit');
Route::get('/undepot/{id}',[DashboardController::class,'getByDepot'])->name('un.depot');
Route::get('/facture/sortie',[FactureController::class,'fac'])->name('facture.fac');
Route::resource('fournisseur',FournisseurController::class);
Route::resource('produit',ProduitController::class);
Route::resource('depot',DepotController::class);
Route::resource('entree',EntreeController::class);
Route::resource('client',ClientController::class);
Route::resource('sortie',SortieController::class);
Route::resource('retour',RetourController::class);
Route::resource('transfert',TransfertController::class);
//Route::resource('chauffeur',ChauffeurController::class);
Route::resource('factur',FactureController::class);
Route::resource('facturee',FactureeController::class);
Route::middleware(['auth', 'admin'])->group(function(){
    Route::get('/user/{user}/edit', 'Auth\RegisterController@edit')->name('user.edit');
    Route::patch('/user/{user}', 'Auth\RegisterController@update')->name('user.update');
    Route::get('/user', 'Auth\RegisterController@index')->name('user.index');
    Route::delete('/user/{user}', 'Auth\RegisterController@delete')->name('user.destroy');
});
Route::resource('categorie',CategorieController::class);

Auth::routes();
Route::post('/stock/produit','App\Http\Controllers\DashboardController@getProduitDepotByIdBetweenToDate')->name('detail.produit.between.to.date');

Route::post('/json/chauffeur', 'ChauffeurController@storeJson')->name('json.chauffeur.store');
Route::post('/json/fournisseur', 'App\Http\Controllers\FournisseurController@storeJson')->name('json.fournisseur.store');
Route::post('/json/client', 'ClientController@storeJson')->name('json.client.store');

Route::post('/chercher/produit', 'App\Http\Controllers\DashboardController@chercherProduit')->name('chercher.produit');
Route::post('/chercher/sortie/date', 'App\Http\Controllers\SortieController@getByDateAndClient')->name('date.client.sortie');
Route::get('/valider/transfert/{id}','App\Http\Controllers\TransfertController@valide')->name('valider.transfert');
Route::get('/non-valider/transfert','App\Http\Controllers\TransfertController@allTansfertForMyDepotNoValidate')->name('nonvalider.transfert');

Route::get('/chercher/produit/{id}', 'App\Http\Controllers\DashboardController@chercherProduitGet')->name('get.chercher.produit');

Route::get('/get/by/facture/{facture_id}', 'App\Http\Controllers\SortieController@getByFacture')->name('get.by.facture');

Route::post('/storeRetourFacture', 'App\Http\Controllers\RetourController@storeRetourFacture')->name('facture.retour.store');

Route::get('/facture/{facture_id}', 'App\Http\Controllers\FactureController@getById')->name('facture.show');
Route::get('/impression/facture/{facture_id}', 'App\Http\Controllers\FactureController@impression')->name('facture.impression');
Route::get('/impression/facturee/{facture_id}', 'App\Http\Controllers\FactureeController@impression')->name('facturee.impression');
Route::post('/entree/sortie/between/date', 'App\Http\Controllers\DepotController@getEntreeAndSortieBetweenDate')->name('entree.sortie.between.date');
Route::get('/modifier/facture/{id}', 'App\Http\Controllers\FactureController@update')->name('modifier.facture');

Route::post('/update/facture', 'App\Http\Controllers\FactureController@updateSortie')->name('facture.edit');
