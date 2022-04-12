<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::paginate(env("PAGINATION_COUNT"));
        return view('admin.categories.categories')->with(
            [
                'categories' => $categories,
                'showLinks' => true,

            ],

        );
    }

    private function categoryNameExists($categoryName)
    {
        $category = Category::where(
            'name',
            '=',
            $categoryName,
        )->get();
        if (count($category) > 0) {
            return true;
        }
        return false;
    }

    public function store(Request $request)
    {

        dd($request);

        $request->validate([
            'category_name' => 'required',
            'category_image' => 'required',
            'image_direction' => 'required',
        ]);

        // check in the request for category_name
        $categoryName = $request->input('category_name');

        // check if category name exists before

        if ($this->categoryNameExists($categoryName)) {
            Session::flash('message', 'Category name already exists');

            // same as return redirect()->back()
            return back();
        }
        // make new instance of the model
        $category = new Category();

        // fillin th data name , directio , image
        $category->name = $categoryName;
        $category->image_direction = $request->input('image_direction');
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $path = $image->store('public');
            $category->image_url = $path;
        }

        // save the category now
        $category->save();


        Session::flash('message', 'category has been added');



        return back();
    }

    public function update(Request $request)
    {

        $request->validate([
            'category_name' => 'required',
            'category_id' => 'required',
        ]);
        $catName = $request->input('category_name');
        $catID = $request->input('category_id');

        if ($this->categoryNameExists($catName)) {
            Session::flash('message', 'Category name already exists');
            return back();
        }
        $cat = Category::find($catID);
        $cat->name = $catName;
        $cat->save();
        Session::flash('message', 'Category has been updated');
        return back();
    }
    public function delete(Request $request)
    {

        $request->validate([
            'category_id' => 'required'
        ]);

        $catId = $request->input('category_id');
        Category::destroy($catId);
        Session::flash('message', 'Category has been deleted');
        return back();
    }
    public function search(Request $request)
    {
        // make sure not post empty form
        $request->validate([
            'category_search' => 'required'
        ]);
        // get search term from unit-name from unit blade
        $searchTerm = $request->input('category_search');

        // get units filled by searching something like search term
        $categories = Category::where(
            'name',
            'LIKE',
            '%' . $searchTerm . '%'
        )->get();

        // dd($units);

        // if there are units exists from search return view with new data
        if (count($categories) > 0) {
            return view('admin.categories.categories')->with([
                'categories' => $categories,
                'showLinks' => false,
            ]);
        }

        Session::flash('message', 'Nothing found!!');

        return redirect()->back();
    }
}
