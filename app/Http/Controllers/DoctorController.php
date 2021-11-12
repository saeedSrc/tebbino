<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $doctor =  Doctor::with('images', 'addresses', 'phones', 'specialties', 'centers')->find($id);
        try {
            return $this->successResponse('doctor', $doctor);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }

    }

    public function comment($doctor_id, CommentRequest $request)
    {

        $user = Auth::user();
        $text = $request->text;
        $rate = $request->rate;
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->doctor_id = $doctor_id;
        $comment->text = $text;
        $comment->save();
        if ($rate) {
            if ($rate >= 0 && $rate <= 5) {
                $doctor = Doctor::find($doctor_id);
                $old_satisfaction = $doctor->satisfaction;
                $old_satisfaction_num = $doctor->satisfaction_num;
                $new_satisfaction_num = $old_satisfaction_num +1;
                $new_satisfaction = floatval(($old_satisfaction + $rate) /$new_satisfaction_num);
                Doctor::whereId($doctor_id)->update(['satisfaction' => $new_satisfaction, 'satisfaction_num' => $new_satisfaction_num]);
            }
        }
    }
}
