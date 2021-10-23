<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::paginate(env("PAGINATION_COUNT"));
        return view('admin.categories.categories')->with(
            ['categories' => $categories,]
        );
    }
    //
}
