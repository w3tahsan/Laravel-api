<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    function variation(){
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.variation.variation', [
            'categories'=>$categories,
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }
    function color_store(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
    function size_store(Request $request){
        Size::insert([
            'category_id'=>$request->category_id,
            'size_name'=>$request->size_name,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
}
