<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UnitController extends Controller
{


    /*
   public function showAdd()
    {
        echo view('admin.units.add_edit');
    }
    */

    public function index()
    {
        // get data from model and pass it from here (controller)
        // to view ----- MVC  MODEL - View - Controller
        //$units = Unit::all();
        //instead of using all data from database
        $units = Unit::orderby('unit_code')->paginate(env("PAGINATION_COUNT"));
        echo view('admin.units.units')->with(['units' => $units]);
    }


    // request parameter is auto ingected
    // which means $requset got the data from the post method
    // from the view
    public function store(Request $request)
    {
        //TODO check if the unit already exisits

        // validate the data
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required',
        ]);

        // make new Data Model object
        $unit = new Unit();
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');

        // Save to database
        $unit->save();

        // send message with key to show that unit was saved
        Session::flash('message', 'Unit ' . $unit->unit_name . ' has been added');


        // return to prev route
        return redirect()->back();
    }

    public function update(Request $request)
    {
        //dd($request);
        //TODO update the given unit
        $request->validate([
            'unit_code' => 'required',
            'unit_id' => 'required',
            'unit_name' => 'required',
        ]);
        $unitId = intval($request->input('unit_id'));
        $unit = Unit::find($unitId);

        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message', 'Unit '.$unit->unit_name.' has been updated');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        //TODO Add Unit Search
    }

    public function delete(Request $request)
    {

        // if unit id is null or empty
        if (is_null($request->input('unit_id')) || empty($request->input('unit_id'))) {
            Session::flash('message', 'Unit ID is Required');
            return redirect()->back();
        }

        // get unit ID
        $id = $request->input('unit_id');

        // delete the models with givin ID
        Unit::destroy($id);

        // send message with key to show that unit was saved
        Session::flash('message', 'Unit has been deleted');


        // return to prev route
        return redirect()->back();
    }
}
