<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }

    public function login(Request $request)
    {

        $user = User::where('username', '=', 'qfahey')->first();
        if ($user) {
            $token_validity =  24 * 60 * 1000;
            $this->guard()->factory()->setTTL($token_validity);
            return $this->respondWithToken(JWTAuth::fromUser($user), false);
        } else {
            $token_validity =  24 * 60 * 1000;
            $this->guard()->factory()->setTTL($token_validity);
            return $this->respondWithToken(JWTAuth::fromUser($user), false);
        }
    }

    public function logout()
    {


        $this->guard()->logout();
        return response()->json([
            'message' => 'user logged out successfully.',
            'success' => true
        ]);
    }

    protected function respondWithToken($token, $already_register) {


        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'token_validity' => $this->guard()->factory()->getTTL() * 60,
            'already_register' => $already_register,
        ]);
    }

    protected function guard() {
        return Auth::guard();
    }

    public function refresh() {
//        return $this->respondWithToken($this->guard()->refresh());
    }
}
