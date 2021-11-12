<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\CenterSpecialTest;
use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use App\Models\SpecialTest;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $doctor_ids = [];
        $center_ids = [];
        $type = $request->type;
        if($type == 'centers') {
            $center_ids = $this->searchCenters($request);
        } else if($type == 'doctors') {
            $doctor_ids = $this->searchDoctors($request);
        } else {
            $doctor_ids = $this->searchDoctors($request);
            $center_ids = $this->searchCenters($request);
        }

        $result = ["centers" => $center_ids, "doctors" => $doctor_ids];

        return $this->successResponse('res', $result);
    }


    public function searchDoctors(Request $request) {
        $doctor_ids = [];
        $specialties = $request->specialties;
        $name = $request->name;
        $province_ids = $request->province_ids;
        $city_ids = $request->city_ids;

        if($specialties) {
            $specialty_ids = Specialty::select('id')->whereIn('name', $specialties)->get();
            $doctor_ids_by_specialty = DoctorSpecialty::select('doctor_id AS id')->whereIn('specialty_id', $specialty_ids)->get();
            $doctor_ids_by_specialty = $this->convertObjToArray($doctor_ids_by_specialty);
            if (count($doctor_ids_by_specialty) == 0) {
                return [];
            }
            $doctor_ids = $doctor_ids_by_specialty;
        }
        if ($name) {
            $doctor_ids_by_name = Doctor::select('id')->where('name', 'like', '%' . $name . '%')->get();
            $doctor_ids_by_name = $this->convertObjToArray($doctor_ids_by_name);
            if (count($doctor_ids_by_name) == 0) {
                return [];
            }
            if (count($doctor_ids) == 0) {
                $doctor_ids = $doctor_ids_by_name;
            } else {

                $doctor_ids = array_intersect($doctor_ids, $doctor_ids_by_name);
            }
        }
        if ($province_ids) {
            $doctor_ids_by_province = Doctor::select('id')->whereIn('province_id', $province_ids)->get();
            $doctor_ids_by_province= $this->convertObjToArray($doctor_ids_by_province);
            if (count($doctor_ids_by_province) == 0) {
                return [];
            }
            if (count($doctor_ids) == 0) {
                $doctor_ids = $doctor_ids_by_province;
            } else {

                $doctor_ids = array_intersect($doctor_ids, $doctor_ids_by_province);
            }
        }
        if ($city_ids) {
            $doctor_ids_by_city = Doctor::select('id')->whereIn('city_id', $city_ids)->get();
            $doctor_ids_by_city =$this->convertObjToArray($doctor_ids_by_city);
            if (count($doctor_ids_by_city) == 0) {
                return [];
            }
            if (count($doctor_ids) == 0) {
                $doctor_ids = $doctor_ids_by_city;
            } else {
                $doctor_ids = array_intersect($doctor_ids, $doctor_ids_by_city);
            }
        }

        return $doctor_ids;
    }

    public function searchCenters(Request $request)
    {
        $center_ids = [];
        $special_tests = $request->special_tests;
        $name = $request->name;
        $province_ids = $request->province_ids;
        $city_ids = $request->city_ids;
        if($special_tests) {
            $special_test_ids = SpecialTest::select('id')->whereIn('name', $special_tests)->get();
            $center_ids_by_special_test = CenterSpecialTest::select('center_id_id AS id')->whereIn('special_test_id', $special_test_ids)->get();
            $center_ids_by_special_test = $this->convertObjToArray($center_ids_by_special_test);
            if (count($center_ids_by_special_test) == 0) {
                return [];
            }
            $center_ids = $center_ids_by_special_test;
        }
        if ($name) {
            $center_ids_by_name = Center::select('id')->where('name', 'like', '%' . $name . '%')->get();
            $center_ids_by_name = $this->convertObjToArray($center_ids_by_name);

            if (count($center_ids_by_name) == 0) {
                return [];
            }
            if (count($center_ids) == 0) {
                $center_ids = $center_ids_by_name;
            } else {

                $center_ids = array_intersect($center_ids, $center_ids_by_name);
            }
        }
        if ($province_ids) {
            $center_ids_by_province = Center::select('id')->whereIn('province_id', $province_ids)->get();
            $center_ids_by_province= $this->convertObjToArray($center_ids_by_province);
            if (count($center_ids_by_province) == 0) {
                return [];
            }
            if (count($center_ids) == 0) {
                $center_ids = $center_ids_by_province;
            } else {

                $center_ids = array_intersect($center_ids, $center_ids_by_province);
            }
        }
        if ($city_ids) {
            $center_ids_by_city = Center::select('id')->whereIn('city_id', $city_ids)->get();
            $center_ids_by_city =$this->convertObjToArray($center_ids_by_city);
            if (count($center_ids_by_city) == 0) {
                return [];
            }
            if (count($center_ids) == 0) {
                $center_ids = $center_ids_by_city;
            } else {
                $center_ids = array_intersect($center_ids, $center_ids_by_city);
            }
        }

        return $center_ids;
    }

    public function convertObjToArray($objs) {
        $result = array();
        foreach ($objs as $obj) {
            array_push($result, $obj->id);
        }

        return $result;
    }
}
