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

        // validate the data
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required',
        ]);

        //Check unit name & unit code still exists

        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (!$this->unitNameExists($unitName)) {
            return redirect()->back();
        }
        if (!$this->unitCodeExists($unitCode)) {
            return redirect()->back();
        }


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

        $request->validate([
            'unit_code' => 'required',
            'unit_id' => 'required',
            'unit_name' => 'required',
        ]);


        //Check unit name & unit code exists

        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (!$this->unitNameExists($unitName)) {
            return redirect()->back();
        }
        if (!$this->unitCodeExists($unitCode)) {
            return redirect()->back();
        }



        $unitId = intval($request->input('unit_id'));
        $unit = Unit::find($unitId);

        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message', 'Unit ' . $unit->unit_name . ' has been updated');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        //TODO Add Unit Search
    }


    private function unitNameExists($unitName)
    {
        // check if unit name exists in database and return first item
        $unit = Unit::where(
            'unit_name',
            '=',
            $unitName,
        )->first();

        if (!is_null($unit)) {
            Session::flash('message', 'Unit Name (' . $unitName . ') already exists');
            return false;
        }

        return true;
    }

    private function unitCodeExists($unitCode)
    {
        $unit = Unit::where(
            'unit_code',
            '=',
            $unitCode,
        )->first();



        if (!is_null($unit)) {
            Session::flash('message', 'Unit Code (' . $unitCode . ') already exists');
            return false;
        }
        return true;
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
