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



        // Categories
        Route::get('categories', 'App\HTTP\Controllers\CategoryController@index')->name('categories');


        //Products
        Route::get('products', 'App\HTTP\Controllers\ProductController@index')->name('products');

        //Tags
        Route::get('tags', 'App\HTTP\Controllers\TagController@index')->name('tags');


        //Payments
        //Orders
        //Shipments


        //Countires
        Route::get('countries', 'App\HTTP\Controllers\CountryController@index')->name('countries');

        //Cites
        Route::get('cities', 'App\HTTP\Controllers\CityController@index')->name('cities');

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
