<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public   function errorResponse($e)
    {
        return response()
            ->json([
                'success' => false,
                'data' => [
                    'code'      =>  $e->getCode(),
                    'message' => 'خطا در شبکه',
                    'message_en'   =>  $e->getMessage(),
                ],
                ]);
    }


    public  function successResponse($data)
    {
        return response()
            ->json([
                'success' => true,
                'data'      =>  $data,
            ]);
    }

    public static function validationError($validator) {
        $response = new JsonResponse([
            'status' => false,
            'data' => [
                'message' => 'The given data is invalid',
                'errors' => $validator->errors()
            ]], 422);


        throw new ValidationException($validator, $response);
    }
}
