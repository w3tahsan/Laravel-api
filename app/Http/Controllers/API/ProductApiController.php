<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    function get_product(){
        $products = Product::with('rel_to_cat')->get();

        return response()->json($products);
    }
    function get_product_details($slug){
        $product_info = Product::where('slug', $slug)->with('rel_to_cat')->with('rel_to_brand')->get();
        $response = [
            'product_info' => $product_info,
            'product_img_link' => 'uploads/product/preview/'.$product_info->first()->preview,
        ];

        return response()->json($response);
    }
}
