<?php

use App\Http\Resources\UserFullResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
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
Route::get('categories/{id}/products', 'App\HTTP\Controllers\Api\CategoryController@products');

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



// Route::post('auth/register','App\HTTP\Controllers\Api\UserController@register');
// Route::post('auth/login','App\HTTP\Controllers\Api\UserController@login');



Route::post('auth/register', 'App\HTTP\Controllers\Api\AuthController@register');
Route::post('auth/login', 'App\HTTP\Controllers\Api\AuthController@login');



Route::group(['middleware' => 'auth:api'], function () {

    Route::post('carts', 'App\HTTP\Controllers\Api\CartController@addProductToCart');

    Route::post('carts/{id}/remove', 'App\HTTP\Controllers\Api\CartController@removeProductFromCart');

    Route::get('carts','App\HTTP\Controllers\Api\CartController@index');
});
