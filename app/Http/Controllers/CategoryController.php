<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Log;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    function category()
    {
        $categories = Category::all();
        return view('admin.category.category', compact('categories'));
    }
    function category_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'icon' => 'required',
            'icon' => 'image',
        ]);

        $icon = $request->icon;
        $extension = $icon->extension();
        $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . random_int(50000, 60000) . '.' . $extension;
        Image::make($icon)->save(public_path('uploads/category/' . $file_name));

        Category::insert([
            'category_name' => $request->category_name,
            'icon' => $file_name,
            'created_at' => Carbon::now(),
        ]);

        Log::insert([
            'user_id' => Auth::id(),
            'model' => 'Category',
            'data' => $request->category_name,
            'action' => 'inserted',
            'created_at' => Carbon::now(),
        ]);

        return back();
    }

    function category_soft_delete($category_id)
    {
        $category = Category::find($category_id);
        Category::find($category_id)->delete();
        Log::insert([
            'user_id' => Auth::id(),
            'model' => 'Category',
            'data' => $category->category_name,
            'action' => 'Soft Deleted',
            'created_at' => Carbon::now(),
        ]);
        return back()->with('soft_delete', 'Category Move to Trash');
    }
    function category_trash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.trash', [
            'categories' => $categories,
        ]);
    }
    function category_restore($id)
    {
        $category = Category::onlyTrashed()->find($id);
        Category::onlyTrashed()->find($id)->restore();
        Log::insert([
            'user_id' => Auth::id(),
            'model' => 'Category',
            'data' => $category->category_name,
            'action' => 'Category Restored',
            'created_at' => Carbon::now(),
        ]);
        return back()->with('restore', 'Category Restored');
    }
    function category_permanent_delete($id)
    {
        $cat = Category::onlyTrashed()->find($id);
        $cat_img  = public_path('uploads/category/' . $cat->icon);
        unlink($cat_img);

        Category::onlyTrashed()->find($id)->forceDelete();

        Subcategory::where('category_id', $id)->update([
            'category_id' => 1,
        ]);

        Log::insert([
            'user_id' => Auth::id(),
            'model' => 'Category',
            'data' => $cat->category_name,
            'action' => 'Category Permanently Deleted',
            'created_at' => Carbon::now(),
        ]);
        return back()->with('pdelete', 'Category Deleted Permanently');
    }

    function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', [
            'category' => $category,
        ]);
    }

    function category_update(Request $request, $id)
    {
        $cat = Category::find($id);

        $request->validate([
            'category_name' => 'required',
        ]);

        if ($request->icon == '') {
            Category::find($id)->update([
                'category_name' => $request->category_name,
            ]);
            Log::insert([
                'user_id' => Auth::id(),
                'model' => 'Category',
                'data' => $cat->category_name,
                'action' => 'Category Permanently Deleted',
                'created_at' => Carbon::now(),
            ]);
            return back();
        } else {
            $cat = Category::find($id);
            $cat_img  = public_path('uploads/category/' . $cat->icon);
            unlink($cat_img);

            $icon = $request->icon;
            $extension = $icon->extension();
            $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . random_int(50000, 60000) . '.' . $extension;
            Image::make($icon)->save(public_path('uploads/category/' . $file_name));

            Category::find($id)->update([
                'category_name' => $request->category_name,
                'icon' => $file_name,
            ]);

            Log::insert([
                'user_id' => Auth::id(),
                'model' => 'Category',
                'data' => $cat->category_name,
                'action' => 'Category Permanently Deleted',
                'created_at' => Carbon::now(),
            ]);

            return back();
        }
    }

    function checked_delete(Request $request)
    {
        foreach ($request->category_id as $category) {
            Category::find($category)->delete();
        }
        return back()->with('soft_delete', 'Category Move to Trash');
    }
    function checked_restore(Request $request)
    {
        foreach ($request->category_id as $category) {
            Category::onlyTrashed()->find($category)->restore();
        }
        return back()->with('restore', 'Category Restored');
    }
}
