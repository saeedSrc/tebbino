<?php

namespace App\Http\Controllers;

use App\Http\Requests\BasicInfoRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SendAuthCode;
use App\Kavenegar\Kavenegar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout', 'sendAuthCode']]);
    }

    public function login(LoginRequest $request)
    {
        $phone = $request->phone_number;
        // after code was entered
        $user = User::where('phone_number', '=', $phone)->first();
        $already_registered = false;
        $token_validity = 24 * 60 * 1000;
        $this->guard()->factory()->setTTL($token_validity);

        if (!$user) {
            $user = new User();
            $user->phone_number = $phone;
            $user->save();
        } else {
            if ($user->first_name) {
                $already_registered = true;
            }
        }

        return $this->respondWithToken(JWTAuth::fromUser($user), $already_registered);

    }

    public function logout()
    {


        $this->guard()->logout();
        return response()->json([
            'message' => 'user logged out successfully.',
            'success' => true
        ]);
    }

    protected function respondWithToken($token, $already_register)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'token_validity' => $this->guard()->factory()->getTTL() * 60,
            'already_register' => $already_register,
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function refresh()
    {
//        return $this->respondWithToken($this->guard()->refresh());
    }

    public function sendAuthCode(SendAuthCode $request)
    {

        $phone = $request->phone_number;
        $code = rand(1001, 9999);
        $sentCode = session($phone);
        $data = [
            'message' => "کد فرستاده شد.",
            'message_en' => "code sent",
        ];
        $kavenegar = new Kavenegar();
        $res = $kavenegar->sendSms($phone, $code, "verify");
        if (!$sentCode) {

            if ($res == 200) {
                session([$phone => $code]);
            } else {
                $data = [
                    'message' => " خطایی در ارسال کد رخ داده است. لطفا مجددا تلاش کنید.",
                    'message_en' => "error on send auth code.",
                ];

            }

        } else {
            $data = [
                'message' => "کد قبلا فرستاده شده است.",
                'message_en' => "code has been sent",
            ];


        }
        return $this->successResponse($data);
    }
}
