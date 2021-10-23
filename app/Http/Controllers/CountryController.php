<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(){
        $countries = Country::paginate(env('PAGINATION_COUNT'));
        return view('admin.countries.countries')->with(
            [
                'countries' => $countries
            ]
            );
    }
}
