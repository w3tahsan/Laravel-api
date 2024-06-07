<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class ApiCountynCityController extends Controller
{
    function country_city()
    {
        $country  = Country::select('id', 'name')->get();
        $city  = City::select('id', 'name', 'country_id')->get();
        $response = [
            'country' => $country,
            'city' => $city,
        ];
        return response()->json($response);
    }
}
