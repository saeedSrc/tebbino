<?php

namespace App\Http\Controllers;

use App\Http\Requests\BasicInfoRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function basicInfo(BasicInfoRequest $request)
    {
        $user = Auth::user();
        try {
            User::whereId($user->id)->update($request->all());
        } catch (\Throwable $e) {
            return $this->errorResponse($e);
        }

        return  $this->successResponse("basicInfo", $user);

    }
}
