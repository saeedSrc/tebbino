<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $doctors = [];
        $center_ids = [];
        $doctor_ids = [];
        $type = $request->type;
        $specialties = $request->specialties;
        $name = $request->name;
        $province_id = $request->province_id;
        $city_id = $request->city_id;
        if($type == 'centres') {

        } else if($type == 'doctors') {
            foreach ($specialties as $specialty) {
                $specialty_ids = Specialty::where('name', '=', $specialty)->select('id')->get();
                foreach ($specialty_ids as $specialty_id) {
                    $doctor_ids_temp = DoctorSpecialty::select('doctor_id')->where('specialty_id', '=', $specialty_id->id)->get();
                    $doctor_ids = array_push($doctor_ids, $doctor_ids_temp);
                }
            }

        } else {

        }
    }
}
