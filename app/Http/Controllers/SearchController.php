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
        $type = $request->type;
        $specialties = $request->specialties;
        $name = $request->name;
        $province_id = $request->province_id;
        $city_id = $request->city_id;
        if($type == 'centres') {

        }

        if($type == 'doctors') {
            foreach ($specialties as $specialty) {
                $specialty_id = Specialty::select('id')->where('name', '=', $specialty)->get();
                $doctor_ids_temp = DoctorSpecialty::select('doctor_id')->where('specialty_id', '=', $specialty_id[0])->get();

                foreach ($doctor_ids_temp as $doctor_id_temp) {
                  $doctors[] =  Doctor::find($doctor_id_temp);
                }
             return $this->successResponse('result', $doctor_ids_temp);
            }

        }else {

        }
    }
}
