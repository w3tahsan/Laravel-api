<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Subcategory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    function add_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $tags = Tag::all();
        return view('admin.product.index', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
            'tags'=>$tags,
        ]);
    }

    function getSubcategory(Request $request){
        $str = '<option value="">Select Category</option>';
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->sub_category.'</option>';
        }
        echo $str;
    }

    function product_store(Request $request){

        $remove = array("@", "#", "(", ")", "*", "/", " ", '"');
        $slug = Str::lower(str_replace($remove, '-', $request->product_name)).'-'.random_int(500000, 600000);
        $preview = $request->preview;
        $extension = $preview->extension();
        $file_name = Str::lower(str_replace($remove, '-', $request->product_name)).'-'.random_int(50000, 60000).'.'.$extension;
        Image::make($preview)->save(public_path('uploads/product/preview/'.$file_name));

        $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'brand_id'=>$request->brand_id,
            'product_name'=>$request->product_name,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'after_discount'=>$request->price - $request->price*$request->discount/100,
            'tags'=>implode(',', $request->tags),
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'addi_info'=>$request->addi_info,
            'preview'=>$file_name,
            'slug'=>$slug,
            'created_at'=>Carbon::now(),
        ]);


            $galleris = $request->gallery;
            $remove = array("@", "#", "(", ")", "*", "/", " ", '"');
            foreach($galleris as $gallery){
               $extension = $gallery->extension();
               $file_name = Str::lower(str_replace( $remove, '-', $request->product_name)).'-'.random_int(50000, 60000).'.'.$extension;
               Image::make($gallery)->save(public_path('uploads/product/gallery/'.$file_name));
               ProductGallery::insert([
                'product_id'=>$product_id,
                'gallery'=>$file_name,
                'created_at'=>Carbon::now(),
               ]);
            }

        return back()->with('success', 'New Product Added!');
    }

    function product_list(){
        $products = Product::paginate(2);
        return view('admin.product.list', [
            'products'=>$products,
        ]);
    }

    function getstatus(Request $request){
        Product::find($request->product_id)->update([
            'status'=>$request->status,
        ]);
    }

}
