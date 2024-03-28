<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    function subcategory(){
        $categories = Category::all();
        return view('admin.subcategory.index', [
            'categories'=>$categories,
        ]);
    }

    function subcategory_store(Request $request){
        $request->validate([
            'category'=>'required',
            'sub_category'=>'required',
        ]);

        if(Subcategory::where('category_id', $request->category)->where('sub_category', $request->sub_category)->exists()){
            return back()->with('exist', 'Subcategory Name Already Exist in this Category');
        }
        else{
            Subcategory::insert([
                'category_id'=>$request->category,
                'sub_category'=>$request->sub_category,
                'created_at'=>Carbon::now(),
            ]);
            return back();
        }
    }

    function subcategory_edit($id){
        $categories = Category::all();
        $subcategory = Subcategory::find($id);
        return view('admin.subcategory.edit', [
            'categories'=>$categories,
            'subcategory'=>$subcategory,
        ]);
    }

    function subcategory_update(Request $request, $id){
        $request->validate([
            'category'=>'required',
            'sub_category'=>'required',
        ]);

        Subcategory::find($id)->update([
            'category_id'=>$request->category,
            'sub_category'=>$request->sub_category,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function subcategory_delete($id){
        Subcategory::find($id)->delete();
        return back()->with('success', 'Subcategory Deleted!');
    }
}
