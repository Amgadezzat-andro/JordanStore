<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class CityController extends Controller
{
    public function index()
    {
        $states = DB::table('states')->get();
        $cities = City::with('states', 'country')->paginate(env('PAGINATION_COUNT'));
        return view('admin.cities.cities')->with([
            'cities' => $cities,
            'states' => $states,
            'showLinks' => true,
        ]);
    }

    public function store(Request $request)
    {

        // validate the data
        $request->validate([
            'city_name' => 'required',
        ]);


        $cityName = $request->input('city_name');


        if ($this->cityNameExists($cityName)) {
            Session::flash('message', 'City name already exists');
            return redirect()->back();
        }


        // make new Data Model object
        $city = new City();
        $city->name = $request->input('city_name');
        // Save to database
        $city->save();

        // send message with key to show that unit was saved
        Session::flash('message', 'City ' . $city->name . ' has been added');


        // return to prev route
        return redirect()->back();
    }


    public function update(Request $request)
    {
        //dd($request);

        $request->validate([
            'city_name' => 'required',
            'city_id' => 'required',
        ]);


        //Check unit name & unit code exists

        $cityName = $request->input('city_name');
        $cityId = intval($request->input('city_id'));


        if ($this->cityNameExists($cityName)) {
            Session::flash('message', 'City name already exists');
            return redirect()->back();
        }


        $city = City::find($cityId);

        $city->name = $request->input('city_name');

        $city->save();

        Session::flash('message', 'City ' . $city->name . ' has been updated');
        return redirect()->back();
    }

    public function search(Request $request)
    {

        // make sure not post empty form
        $request->validate([
            'city_search' => 'required'
        ]);
        // get search term from unit-name from unit blade
        $searchTerm = $request->input('city_search');

        // get units filled by searching something like search term
        $cities = City::where(
            'name',
            'LIKE',
            '%' . $searchTerm . '%'
        )->get();

        // dd($units);

        // if there are units exists from search return view with new data
        if (count($cities) > 0) {
            return view('admin.cities.cities')->with([
                'cities' => $cities,
                'showLinks' => false,
            ]);
        }

        Session::flash('message', 'Nothing found!!');

        return redirect()->back();
    }


    private function cityNameExists($cityName)
    {
        $city = City::where(
            'name',
            '=',
            $cityName,
        )->get();
        if (count($city) > 0) {
            return true;
        }
        return false;
    }


    public function delete(Request $request)
    {

        $request->validate([
            'category_id' => 'required'
        ]);

        $cityId = $request->input('city_id');
        City::destroy($cityId);
        Session::flash('message', 'City has been deleted');
        return back();
    }
}
