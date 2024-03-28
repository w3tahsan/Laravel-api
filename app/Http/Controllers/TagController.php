<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function tag(){
        $tags = Tag::all();
        return view('admin.tag.tag', [
            'tags'=>$tags,
        ]);
    }
    function tag_store(Request $request){
        Tag::insert([
            'tag_name'=>$request->tag_name,
        ]);
        return back();
    }
}
