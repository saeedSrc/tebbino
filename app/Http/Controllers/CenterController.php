<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Schema;

class CenterController extends Controller
{
    public function OverView()
    {
        $center_overview = Center::select('id', 'name')->with('images', 'addresses')->get();
        return $this->successResponse('centers', $center_overview);
    }


}


