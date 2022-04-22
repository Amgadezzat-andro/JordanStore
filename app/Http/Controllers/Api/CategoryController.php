<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }
    public function show($id)
    {
        return new CategoryResource(Category::find($id));
    }
    public function products($id){
        $category = Category::findOrFail($id);
        return ProductResource::collection($category->products()->paginate());
    }
}
