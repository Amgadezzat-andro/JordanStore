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

        // make new Data Model object
        $unit = new Unit();
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');

        // Save to database
        $unit->save();

        // send message with key to show that unit was saved
        Session::flash('message','Unit '.$unit->unit_name.' has been added'); 


        // return to prev route
        return redirect()->back();
    }
}
