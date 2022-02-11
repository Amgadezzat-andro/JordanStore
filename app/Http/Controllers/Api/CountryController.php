<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\StateResource;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(){

        return CountryResource::collection(Country::paginate());

    }
    public function showStates($id){

        $country = Country::find($id);
        return StateResource::collection($country->states);

    }
    public function showCities($id){
        $country = Country::find($id);
        return CityResource::collection($country->cities);
    }
}
