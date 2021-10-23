<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){

        $reviews = Review::with(['product','customer'])->paginate(env('PAGINATION_COUNT'));
      // return $reviews;

        return view('admin.reviews.reviews')->with([
            'reviews' => $reviews
        ]);
    }
}
