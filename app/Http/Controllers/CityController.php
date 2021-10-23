<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){
        $cities = City::with('states','country')->paginate(env('PAGINATION_COUNT'));
        return view('admin.cities.cities')->with([
            'cities' => $cities
        ]);
    }
}
