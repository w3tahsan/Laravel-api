<?php

namespace App\Http\Controllers;

use App\Models\Offer1;
use App\Models\Offer2;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class OfferController extends Controller
{
    function offer(){
        $offer = Offer1::all();
        $offer2 = Offer2::all();
        return view('admin.offer.offer', [
            'offer'=>$offer,
            'offer2'=>$offer2,
        ]);
    }

    function offer1_update(Request $request, $id){
        if($request->image == ''){
            Offer1::find($id)->update([
                'title'=>$request->title,
                'price'=>$request->price,
                'discount_price'=>$request->discount_price,
                'date'=>$request->date,
            ]);
            return back();
        }
        else{
            $offer = Offer1::find($id);
            $current = public_path('uploads/offer/'.$offer->image);
            unlink($current);
            $image = $request->image;
            $extension = $image->extension();
            $file_name = 'offer1'.'-'.random_int(100,999).'.'.$extension;
            Image::make($image)->save(public_path('uploads/offer/'.$file_name));
            Offer1::find($id)->update([
                'title'=>$request->title,
                'price'=>$request->price,
                'discount_price'=>$request->discount_price,
                'date'=>$request->date,
                'image'=>$file_name,
            ]);
            return back();

        }
    }
    function offer2_update(Request $request, $id){
        if($request->image == ''){
            Offer2::find($id)->update([
                'title'=>$request->title,
                'subtitle'=>$request->subtitle,
            ]);
            return back();
        }
        else{
            $offer2 = Offer2::find($id);
            $current = public_path('uploads/offer/'.$offer2->image);
            unlink($current);
            $image = $request->image;
            $extension = $image->extension();
            $file_name = 'offer2'.'-'.random_int(100,999).'.'.$extension;
            Image::make($image)->save(public_path('uploads/offer/'.$file_name));
            Offer2::find($id)->update([
                'title'=>$request->title,
                'subtitle'=>$request->subtitle,
                'image'=>$file_name,
            ]);
            return back();

        }
    }
}
