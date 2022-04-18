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
//Route::get('units-test','DataImportController@importUnits');

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(
    ['auth', 'user_is_admin'],
    function () {

        //Units

        //Get  Unit Data
        Route::get('units', 'UnitController@index')->name('units');
        //Post Add Unit
        Route::post('units', 'UnitController@store');
        // Delete Unit
        Route::delete('units', 'UnitController@delete');
        //Update Unit
        Route::put('units', 'UnitController@update');
        // Search for unit
        // laravel knows that this will be dynamic value
        Route::get('search-unit', 'UnitController@search')->name('search-units');




        // Categories
        Route::get('categories', 'CategoryController@index')->name('categories');
        Route::post('categories', 'CategoryController@store');
        Route::delete('categories', 'CategoryController@delete');
        Route::get('search-categories', 'CategoryController@search')->name('search-categories');
        Route::put('categories', 'CategoryController@update');


        //Products
        Route::get('products', 'ProductController@index')->name('products');

        // ? is used because maybe there is new product which has no id
        // ? means id here is optional
        Route::get('new-product','ProductController@newProduct')->name('new-product');

        Route::post('new-product', 'ProductController@store');

        Route::get('update-product/{id}','ProductController@newProduct')->name('update-product-form');


        Route::put('update-product','ProductController@update')->name('update-product');


        Route::delete('products/{id}','ProductController@delete');

        Route::post('delete-image','ProductController@deleteImage')->name('delete-image');

        //Tags
        Route::get('tags', 'TagController@index')->name('tags');
        Route::post('tags', 'TagController@store');
        Route::delete('tags', 'TagController@delete');
        Route::get('search-tags', 'TagController@search')->name('search-tags');
        Route::put('tags', 'TagController@update');




        //Payments
        //Orders
        //Shipments


        //Countires
        Route::get('countries', 'CountryController@index')->name('countries');

        //Cites
        Route::get('cities', 'CityController@index')->name('cities');
        Route::post('cities', 'CityController@store');
        Route::delete('cities', 'CityController@delete');
        Route::get('search-cities', 'CityController@search')->name('search-cities');
        Route::put('cities', 'CityController@update');



        //States
        Route::get('states', 'StateController@index')->name('states');


        //Reviews
        Route::get('reviews', 'ReviewController@index')->name('reviews');

        //Tickets
        Route::get('tickets', 'TicketController@index')->name('tickets');



        //Roles
        Route::get('roles', 'RoleController@index')->name('roles');
    }
);
