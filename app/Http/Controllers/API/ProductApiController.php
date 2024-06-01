<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    function get_product(){
        $products = Product::with('rel_to_cat')->get();
        $response = [
            'products' => $products,
            'preview' => env('APP_URL').'/uploads/product/preview/',
        ];
        return response()->json($response);
    }
    function get_product_details($slug){
        $product_id = Product::where('slug', $slug)->first()->id;
        $product_info = Product::where('slug', $slug)->with('rel_to_cat')->with('rel_to_brand')->first();
        $gals = ProductGallery::where('product_id', $product_info->id)->get();
        $available_colors = Inventory::where('product_id', $product_id)
            ->groupBy('color_id')
            ->selectRaw('sum(color_id) as sum, color_id')
            ->with('rel_to_color')->get();
        $available_sizes = Inventory::where('product_id', $product_id)
            ->groupBy('size_id')
            ->selectRaw('sum(size_id) as sum, size_id')
            ->with('rel_to_size')->get();
        $response = [
            'data' => $product_info,
            'gals' => $gals,
            'gallery' => env('APP_URL').'/uploads/product/gallery/',
            'preview' => env('APP_URL').'/uploads/product/preview/',
            'available_colors' => $available_colors,
            'available_sizes' => $available_sizes,
        ];
        return response()->json($response);
    }
}
