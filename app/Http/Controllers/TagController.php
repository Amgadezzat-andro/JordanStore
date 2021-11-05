<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::paginate(env('PAGINATION_COUNT'));
        return view('admin.tags.tags')->with([
            'tags' => $tags
        ]);
    }



    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'tag_name' => 'required'
        ]);

        // get tag_name from request
        $tagName = $request->input('tag_name');

        // search for identical tags
        // it will return as collection
        $tag = Tag::where('tag', '=', $tagName)->get();

        // if there is identical tag return message and go back
        if (count($tag) > 0) {
            Session::flash('message', 'Tag '.$tagName.' already exists');
            return redirect()->back();
        }
        //else create new tag and assign the value into it and save
        $newTag = new Tag();
        $newTag->tag = $tagName;
        $newTag->save();

        Session::flash('message', 'Tag ' . $tagName . ' has been added');
        return redirect()->back();
    }
}
