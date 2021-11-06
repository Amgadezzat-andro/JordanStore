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
            'tags' => $tags,
            'showLinks' => true,

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
            Session::flash('message', 'Tag ' . $tagName . ' already exists');
            return redirect()->back();
        }
        //else create new tag and assign the value into it and save
        $newTag = new Tag();
        $newTag->tag = $tagName;
        $newTag->save();

        Session::flash('message', 'Tag ' . $tagName . ' has been added');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'tag_id' => 'required'
        ]);

        $tagId = $request->input('tag_id');
        $tag = Tag::destroy($tagId);
        Session::flash('message', 'tag has been deleted');
        return redirect()->back();
    }

    public function search(Request $request)
    {

        // make sure not post empty form
        $request->validate([
            'tag_search' => 'required'
        ]);
        // get search term from unit-name from unit blade
        $searchTerm = $request->input('tag_search');

        // get units filled by searching something like search term
        $tags = Tag::where(
            'tag',
            'LIKE',
            '%' . $searchTerm . '%'
        )->get();

        // dd($units);

        // if there are units exists from search return view with new data
        if (count($tags) > 0) {
            return view('admin.tags.tags')->with([
                'tags' => $tags,
                'showLinks' => false,
            ]);
        }

        Session::flash('message', 'Nothing found!!');

        return redirect()->back();
    }

    private function tagNameExists($tagName)
    {
        // check if unit name exists in database and return first item
        $tag = Tag::where(
            'tag',
            '=',
            $tagName,
        )->first();

        if (!is_null($tag)) {
            Session::flash('message', 'Tag Name (' . $tagName . ') already exists');
            return false;
        }

        return true;
    }

    public function update(Request $request)
    {
        $request->validate([
            'tag_name' => 'required',
            'tag_id' => 'required',
        ]);
        $tagName = $request->input('tag_name');
        $tagID = $request->input('tag_id');

        if (!$this->tagNameExists($tagName)) {
            Session::flash('message', 'Tag name already exists');
            return redirect()->back();
        }
        $tag = Tag::find($tagID);
        $tag->tag = $tagName;
        $tag->save();
        Session::flash('message', 'Tag has been updated');
        return redirect()->back();
    }
}
