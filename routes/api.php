<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/countries', [CountryController::class, 'index']);
Route::post('/countries', [CountryController::class, 'store']);
Route::get('/countries/{country}', [CountryController::class, 'show']);
Route::patch('/countries/{country}', [CountryController::class, 'update']);
Route::delete('/countries/{country}', [CountryController::class, 'destroy']);
Route::get('/countries-select', [CountryController::class, 'countriesSelect']);

Route::post('/states', [StateController::class, 'store']);
Route::get('/states/{state}', [StateController::class, 'show']);
Route::patch('/states/{state}', [StateController::class, 'update']);
Route::delete('/states/{state}', [StateController::class, 'destroy']);
Route::get('/list-states-by-country/{country}', [StateController::class, 'listStatesByCountry']);
Route::get('/list-states-by-country-select/{country}', [StateController::class, 'listStatesByCountrySelect']);

Route::post('/cities', [CityController::class, 'store']);
Route::get('/cities/{city}', [CityController::class, 'show']);
Route::patch('/cities/{city}', [CityController::class, 'update']);
Route::delete('/cities/{city}', [CityController::class, 'destroy']);
Route::get('/list-cities-by-state/{state}', [CityController::class, 'listCitiesByState']);
Route::get('/list-cities-by-state-select/{state}', [CityController::class, 'listCitiesByStateSelect']);
