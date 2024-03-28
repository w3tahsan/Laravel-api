<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    function banner(){
        $categories = Category::all();
        $banners = Banner::all();
        return view('admin.banner.banner', [
            'categories'=>$categories,
            'banners'=>$banners,
        ]);
    }

    function banner_store(Request $request){
        $image = $request->image;
        $extension = $image->extension();
        $file_name = 'banner'.'-'.random_int(50000, 60000).'.'.$extension;
        Image::make($image)->save(public_path('uploads/banner/'.$file_name));

        Banner::insert([
            'title'=>$request->title,
            'image'=>$file_name,
            'category_id'=>$request->id,
            'created_at'=>Carbon::now(),
        ]);

        return back();
    }
}
