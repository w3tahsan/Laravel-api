<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    function brand(){
        $brands = Brand::all();
        return view('admin.brand.brand', [
            'brands'=>$brands,
        ]);
    }
    function brand_store(Request $request){
        $logo = $request->brand_logo;
        $extension = $logo->extension();
        $file_name = Str::lower(str_replace(' ', '-', $request->brand_name)).'.'.$extension;
        Image::make($logo)->save(public_path('uploads/brand/'.$file_name));

        Brand::insert([
            'brand_name'=>$request->brand_name,
            'brand_logo'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);

        return back();
    }
}
