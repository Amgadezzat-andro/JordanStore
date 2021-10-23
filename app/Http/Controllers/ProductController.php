<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])->paginate(env("PAGINATION_COUNT"));
        $currencyCode = env("CURRENCY_CODE", "$");
        // if you want to return json
        //return $products;


        return view('admin.products.products')->with(
            [
                'products' => $products,
                'currency_code' => $currencyCode,
            ]
        );
    }
}
