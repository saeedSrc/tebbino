<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Center;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Schema;
use Illuminate\Support\Facades\Auth;

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
        $center =  Center::with('images', 'addresses', 'phones', 'hoursOfWorks', 'specialTests', 'doctors', 'insuranceCompanies')->find($id);
        try {
            return $this->successResponse('center', $center);
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }

    }


    public function comment($center_id, CommentRequest $request)
    {

        $user = Auth::user();
        $text = $request->text;
        $rate = $request->rate;
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->center_id = $center_id;
        $comment->text = $text;
        if ($rate) {
            $comment->rate = $rate;
        }
        $comment->save();
        if ($rate) {
            if ($rate >= 0 && $rate <= 5) {
                $center = Center::find($center_id);
               $old_satisfaction = $center->satisfaction;
               $old_satisfaction_num = $center->satisfaction_num;
               $new_satisfaction_num = $old_satisfaction_num +1;
               $new_satisfaction = floatval(($old_satisfaction + $rate) /$new_satisfaction_num);
                Center::whereId($center_id)->update(['satisfaction' => $new_satisfaction, 'satisfaction_num' => $new_satisfaction_num]);
            }
        }
        $comment->user = $user;
        return $this->successResponse('comment', $comment);
    }

    public function GetAllComments($center_id)
    {
        $comments = Comment::where('center_id', '=', $center_id)->with('user')->get();
        return $this->successResponse('comments', $comments);
    }
}


