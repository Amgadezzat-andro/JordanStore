<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

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
}
