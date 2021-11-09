<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

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

    public function All()
    {

        $doctor_overview = Doctor::with('images', 'addresses')->get();
        return $this->successResponse('doctors', $doctor_overview);
    }

    public function Get($id)
    {
        $doctor =  Doctor::with('images', 'addresses', 'phones')->find($id);
        try {
            return $this->successResponse('doctor', $doctor);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }

    }
}
