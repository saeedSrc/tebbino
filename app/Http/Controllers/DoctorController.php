<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function OverView()
    {

        $doctor_overview = Doctor::select('id', 'name', 'satisfaction')->with('images', 'addresses')->get();
        return $this->successResponse('doctors', $doctor_overview);
    }
}
