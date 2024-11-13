<?php

namespace App\Http\Controllers;

use App\Models\Location\City;
use App\Models\Location\District;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function selectCities(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $cities = City::select('name as text', 'id');
            if (!empty($search)) {
                $cities->where('name', 'like', '%' . $search . '%');
            }
            return response()->json(['status' => 200, 'data' => $cities->get()], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
    public function selectDistricts(Request $request, int $cityId)
    {
        try {
            $search = $request->input('search', '');
            $districts = District::select('name as text', 'id');
            if (!empty($search)) {
                $districts->where('name', 'like', '%' . $search . '%');
            }
            $districts->where('city_id', $cityId);
            return response()->json(['status' => 200, 'data' => $districts->get()], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
