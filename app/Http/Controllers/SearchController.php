<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $type = $request->type;
        $specialties = $request->specialties;
        $name = $request->name;
        $province = $request->province;
        $city = $request->city;
        if($type == 'centres') {

        }

        if($type == 'doctors') {

        }else {

        }
    }
}
