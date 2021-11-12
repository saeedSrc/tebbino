<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class LocalInformation extends Controller
{
    public function getProvinces(Request $request)
    {
        return "kose masd";
//        var_dump("LOSSSSSSSSSSSSSSSSSSSSS");
//        $provinces =  Province::all();
//
//        foreach ($provinces as $province) {
//            var_dump($province->name);
//        }
//        return $this->successResponse('provinces', $provinces);
    }

    public function getCities($provinceId)
    {

        if($provinceId == null) {
            $provinceId = 1;
        }
        try {
            $province = Province::findOrFail($provinceId);

            $cities =  $province->cities;
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }

        return $this->successResponse('cities', $cities);
    }

}
