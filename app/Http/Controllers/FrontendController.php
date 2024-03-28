<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Offer1;
use App\Models\Offer2;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Subscribe;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class FrontendController extends Controller
{

    function tag_product($id)
    {
        $all = '';
        foreach (Product::all() as $product) {
            $explode = explode(',', $product->tags);
            if (in_array($id, $explode)) {
                $all .= $product->id . ',';
            }
        }
        $explode2 = explode(',', $all);
        $tag_products = Product::find($explode2);
        return view('frontend.tag_product', [
            'tag_products' => $tag_products,
        ]);
    }

    function api_category()
    {

        $categories = file_get_contents('http://127.0.0.1:8000/api/get/category');
        $categories = json_decode($categories);

        return view('apicat', [
            'categories' => $categories,
        ]);
    }

    function welcome()
    {
        $banners = Banner::all();
        $categories = Category::all();
        $offer = Offer1::all();
        $offer2 = Offer2::all();
        $products = Product::latest()->take(8)->get();
        return view('frontend.index', [
            'banners' => $banners,
            'categories' => $categories,
            'offer' => $offer,
            'offer2' => $offer2,
            'products' => $products,
        ]);
    }

    function subscribe_store(Request $request)
    {
        Subscribe::insert([
            'customer_id' => 1,
            'email' => $request->email,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }

    function product_details($slug)
    {
        $product_id = Product::where('slug', $slug)->first()->id;
        $product_info = Product::find($product_id);
        $gallery = ProductGallery::where('product_id', $product_id)->get();
        $reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->get();
        $total_reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->count();
        $total_stars = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->sum('star');
        $available_colors = Inventory::where('product_id', $product_id)
            ->groupBy('color_id')
            ->selectRaw('sum(color_id) as sum, color_id')
            ->get();
        $available_sizes = Inventory::where('product_id', $product_id)
            ->groupBy('size_id')
            ->selectRaw('sum(size_id) as sum, size_id')
            ->get();

        //recent view
        $all = Cookie::get('recent-view');

        if (!$all) {
            $all = "[]";
        }
        $all_info = json_decode($all, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $recent_product_id = json_encode($all_info);
        Cookie::queue('recent-view', $recent_product_id, 1000);
        return view('frontend.product_details', [
            'product_info' => $product_info,
            'gallery' => $gallery,
            'available_colors' => $available_colors,
            'available_sizes' => $available_sizes,
            'reviews' => $reviews,
            'total_reviews' => $total_reviews,
            'total_stars' => $total_stars,
        ]);
    }

    function getSize(Request $request)
    {
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach ($sizes as $size) {
            if ($size->rel_to_size->size_name == 'NA') {
                $str = '<li class="color"><input checked class="size_id" id="size' . $size->size_id . '" type="radio" name="size_id" value="' . $size->size_id . '"><label for="size' . $size->size_id . '">' . $size->rel_to_size->size_name . '</label>
                </li>';
            } else {
                $str .= '<li class="color"><input class="size_id" id="size' . $size->size_id . '" type="radio" name="size_id" value="' . $size->size_id . '"><label for="size' . $size->size_id . '">' . $size->rel_to_size->size_name . '</label>
                </li>';
            }
        }
        echo $str;
    }

    function getQuantity(Request $request)
    {
        $str = '';
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
        if ($quantity == 0) {
            $str = '<strong id="quan" class="btn btn-danger" >Out of Stock</strong>';
        } else {
            $str = '<strong id="quan" class="btn btn-success" >' . $quantity . ' In Stock</strong>';;
        }
        echo $str;
    }

    function review_store(Request $request, $id)
    {
        $request->validate([
            'review' => 'required',
            'stars' => 'required',
        ]);
        OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $id)->first()->update([
            'review' => $request->review,
            'star' => $request->stars,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('review', 'Review Submitted success');
    }

    function shop(Request $request)
    {
        $data = $request->all();

        $based = 'created_at';
        $type = 'DESC';

        if (!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined') {
            if ($data['sort'] == 1) {
                $based = 'price';
                $type = 'ASC';
            } else if ($data['sort'] == 2) {
                $based = 'price';
                $type = 'DESC';
            } else if ($data['sort'] == 3) {
                $based = 'product_name';
                $type = 'ASC';
            } else if ($data['sort'] == 4) {
                $based = 'product_name';
                $type = 'DESC';
            }
        }



        $products = Product::where(function ($q) use ($data) {
            $min = 0;
            $max = 0;
            if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined') {
                $min = $data['min'];
            } else {
                $min = 1;
            }
            if (!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined') {
                $max = $data['max'];
            } else {
                $max = Product::max('price');
            }

            if (!empty($data['search_input']) && $data['search_input'] != '' && $data['search_input'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('product_name', 'like', '%' . $data['search_input'] . '%');
                    // $q->orWhere('long_desp', 'like', '%'.$data['search_input'].'%');
                    // $q->orWhere('addi_info', 'like', '%'.$data['search_input'].'%');
                });
            }
            if (!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('category_id', $data['category_id']);
                });
            }
            if (!empty($data['tag']) && $data['tag'] != '' && $data['tag'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $all = '';
                    foreach (Product::all() as $product) {
                        $explode = explode(',', $product->tags);
                        if (in_array($data['tag'], $explode)) {
                            $all .= $product->id . ',';
                        }
                    }
                    $explode2 = explode(',', $all);
                    $q->find($explode2);
                });
            }
            if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                $q->whereHas('rel_to_inventory', function ($q) use ($data) {
                    if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                        $q->whereHas('rel_to_color', function ($q) use ($data) {
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                });
            }
            if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
                $q->whereHas('rel_to_inventory', function ($q) use ($data) {
                    if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                        $q->whereHas('rel_to_color', function ($q) use ($data) {
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                    if (!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
                        $q->whereHas('rel_to_size', function ($q) use ($data) {
                            $q->where('sizes.id', $data['size_id']);
                        });
                    }
                });
            }
            if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined') {
                $q->whereBetween('price', [$min, $max]);
            }
        })->orderBy($based, $type)->get();



        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $tags = Tag::all();
        return view('frontend.shop', [
            'products' => $products,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'tags' => $tags,
        ]);
    }

    function recent_view()
    {
        $recent_info = json_decode(Cookie::get('recent-view'), true);
        if ($recent_info == Null) {
            $recent_viewed_product = [];
            $recent_viewed = array_unique($recent_info);
        } else {
            $recent_viewed = array_reverse(array_unique($recent_info));
        }
        $recents = Product::find($recent_viewed);
        return view('frontend.recent_view', [
            'recents' => $recents,
        ]);
    }
}
