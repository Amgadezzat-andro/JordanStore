<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Image;
use App\Models\State;
use App\Models\Product;
use App\Models\Role;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// just for import the units data
//Route::get('units-test','App\HTTP\Controllers\DataImportController@importUnits');

// Route::get('userRole-test', function () {
//     $role = Role::find(1);
//     return $role->users;
// });

// Route::get('roleUser-test', function () {
//     $user = User::find(501);
//     return $user->roles;
// });


// Route::get('tagp-test', function () {
//     $products = Product::find(1);
//     return $products->tags;
// });


// Route::get('tag-test', function () {
//     $tag = Tag::find(2);
//     return $tag->products;
// });

// Route::get('test-email', function () {
//     return 'Hello';
// })->middleware(['auth', 'email_verified', 'user_is_support', 'user_is_admin']);


Route::get('/', function () {
    return view('welcome');
});

// Route::get('cities', function () {
//     return City::with(['states', 'country'])->paginate(50);
// });

// Route::get('countries', function () {
//     return Country::with(['cities', 'states'])->paginate(5);
// });

// Route::get('states', function () {
//     return State::with(['country', 'cities'])->paginate(5);
// });


// Route::get('users', function () {
//     return User::paginate(100);
// });

// Route::get('products', function () {
//     return Product::with(['images'])->paginate(100);
// });

// Route::get('images', function () {
//     return Image::with(['product'])->paginate(100);
// });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(
    ['auth', 'user_is_admin'],
    function () {

        //Units

        //Get  Unit Data
        Route::get('units', 'App\HTTP\Controllers\UnitController@index')->name('units');
        //Post Add Unit
        Route::post('units', 'App\HTTP\Controllers\UnitController@store');
        // Delete Unit
        Route::delete('units', 'App\HTTP\Controllers\UnitController@delete');
        //Update Unit
        Route::put('units', 'App\HTTP\Controllers\UnitController@update');
        // Search for unit
        // laravel knows that this will be dynamic value
        Route::get('search-unit', 'App\HTTP\Controllers\UnitController@search')->name('search-units');




        // Categories
        Route::get('categories', 'App\HTTP\Controllers\CategoryController@index')->name('categories');
        Route::post('categories', 'App\HTTP\Controllers\CategoryController@store');
        Route::delete('categories', 'App\HTTP\Controllers\CategoryController@delete');
        Route::get('search-categories', 'App\HTTP\Controllers\CategoryController@search')->name('search-categories');
        Route::put('categories', 'App\HTTP\Controllers\CategoryController@update');


        //Products
        Route::get('products', 'App\HTTP\Controllers\ProductController@index')->name('products');

        // ? is used because maybe there is new product which has no id
        // ? means id here is optional
        Route::get('new-product','App\HTTP\Controllers\ProductController@newProduct')->name('new-product');

        Route::post('new-product', 'App\HTTP\Controllers\ProductController@store');

        Route::get('update-product/{id}','App\HTTP\Controllers\ProductController@newProduct')->name('update-product-form');


        Route::put('update-product','App\HTTP\Controllers\ProductController@update')->name('update-product');


        Route::delete('products/{id}','App\HTTP\Controllers\ProductController@delete');

        Route::post('delete-image','App\HTTP\Controllers\ProductController@deleteImage')->name('delete-image');

        //Tags
        Route::get('tags', 'App\HTTP\Controllers\TagController@index')->name('tags');
        Route::post('tags', 'App\HTTP\Controllers\TagController@store');
        Route::delete('tags', 'App\HTTP\Controllers\TagController@delete');
        Route::get('search-tags', 'App\HTTP\Controllers\TagController@search')->name('search-tags');
        Route::put('tags', 'App\HTTP\Controllers\TagController@update');




        //Payments
        //Orders
        //Shipments


        //Countires
        Route::get('countries', 'App\HTTP\Controllers\CountryController@index')->name('countries');

        //Cites
        Route::get('cities', 'App\HTTP\Controllers\CityController@index')->name('cities');
        Route::post('cities', 'App\HTTP\Controllers\CityController@store');
        Route::delete('cities', 'App\HTTP\Controllers\CityController@delete');
        Route::get('search-cities', 'App\HTTP\Controllers\CityController@search')->name('search-cities');
        Route::put('cities', 'App\HTTP\Controllers\CityController@update');



        //States
        Route::get('states', 'App\HTTP\Controllers\StateController@index')->name('states');


        //Reviews
        Route::get('reviews', 'App\HTTP\Controllers\ReviewController@index')->name('reviews');

        //Tickets
        Route::get('tickets', 'App\HTTP\Controllers\TicketController@index')->name('tickets');



        //Roles
        Route::get('roles', 'App\HTTP\Controllers\RoleController@index')->name('roles');
    }
);
