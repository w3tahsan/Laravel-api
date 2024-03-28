<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CategoryApiController extends Controller
{
    function get_category()
    {
        $categories = Category::select('category_name', 'icon')->get();
        return response()->json($categories);
    }

    function category_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories',
            'icon' => 'required',
            'icon' => 'image',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $icon = $request->icon;
        $extension = $icon->extension();
        $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . random_int(50000, 60000) . '.' . $extension;
        Image::make($icon)->save(public_path('uploads/category/' . $file_name));

        $category = Category::create([
            'category_name' => $request->category_name,
            'icon' => $file_name,
            'created_at' => Carbon::now(),
        ]);

        $response = [
            'category' => $category,
            'message' => 'Category Added Successfully',
        ];

        return response()->json($response);
    }

    function category_show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            $response = [
                'message' => 'No Data Found',
            ];

            return response()->json($response);
        }
        $response = [
            'category' => $category,
        ];

        return response()->json($response);
    }

    function category_update(Request $request, $id)
    {

        if ($request->icon == null) {
            Category::find($id)->update([
                'category_name' => $request->category_name,
            ]);
            $response = [
                'message' => 'Category Updated Success',
            ];
            return response()->json($response);
        } else {
            $validator = Validator::make($request->all(), [
                'icon' => 'required',
                'icon' => 'image',
            ]);

            if ($validator->fails()) {
                return $validator->errors()->all();
            }
            $category = Category::find($id);
            $del_from = public_path('uploads/category/' . $category->icon);
            unlink($del_from);

            $icon = $request->icon;
            $extension = $icon->extension();
            $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . random_int(50000, 60000) . '.' . $extension;
            Image::make($icon)->save(public_path('uploads/category/' . $file_name));

            $category = Category::find($id)->update([
                'category_name' => $request->category_name,
                'icon' => $file_name,
                'created_at' => Carbon::now(),
            ]);

            $response = [
                'category' => $category,
                'message' => 'Category Updated Success',
            ];

            return response()->json($response);
        }
    }

    function category_delete($id)
    {
        // $category = Category::find($id);
        // $del_from = public_path('uploads/category/' . $category->icon);
        // unlink($del_from);

        Category::find($id)->delete();
        $response = [
            'message' => 'Category Deleted Success',
        ];

        return response()->json($response);
    }
}
