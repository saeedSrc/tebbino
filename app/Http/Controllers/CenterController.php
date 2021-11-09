<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Schema;

class CenterController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function OverView()
    {
        $center_overview = Center::select('id', 'name')->with('images', 'addresses')->get();
        return $this->successResponse('centers', $center_overview);
    }


    public function All()
    {
        $center_overview = Center::with('images', 'addresses')->get();
        return $this->successResponse('centers', $center_overview);
    }

    public function Get($id)
    {
        $center =  Center::with('images', 'addresses', 'phones')->find($id);
        try {
            return $this->successResponse('center', $center);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }

    }


}


