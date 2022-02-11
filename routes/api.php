<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Get Categories
Route::get('categories', 'App\HTTP\Controllers\Api\CategoryController@index');
Route::get('categories/{id}', 'App\HTTP\Controllers\Api\CategoryController@show');

//Get Tags
Route::get('tags', 'App\HTTP\Controllers\Api\TagController@index');
Route::get('tags/{id}', 'App\HTTP\Controllers\Api\TagController@show');
//Get Products
Route::get('products', 'App\HTTP\Controllers\Api\ProductController@index');
Route::get('products/{id}', 'App\HTTP\Controllers\Api\ProductController@show');

//General Route
Route::get('countries', 'App\HTTP\Controllers\Api\CountryController@index');
Route::get('countries/{id}/states', 'App\HTTP\Controllers\Api\CountryController@showStates');
Route::get('countries/{id}/cities', 'App\HTTP\Controllers\Api\CountryController@showCities');





Route::group(['auth:api'], function () {

    //get full products

});
