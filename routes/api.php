<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LocalInformation;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/provinces', [LocalInformation::class, 'getProvinces']);

// url parameters: province(int)
Route::get('/cities/{province_id}', [LocalInformation::class, 'getCities']);


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('send_auth_code', [AuthController::class, 'sendAuthCode']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);

});

Route::post('basic_info', [UserController::class, 'basicInfo']);
Route::get('user', [UserController::class, 'get']);


// centers
Route::group([
    'middleware' => 'api',
    'prefix' => 'centers'
], function ($router) {
    Route::get('overview', [CenterController::class, 'OverView']);
    Route::get('all', [CenterController::class, 'All']);
    Route::get('{id}', [CenterController::class, 'Get']);

});



// doctors
Route::group([
    'middleware' => 'api',
    'prefix' => 'doctors'
], function ($router) {
    Route::get('overview', [DoctorController::class, 'OverView']);
    Route::get('all', [DoctorController::class, 'All']);
    Route::get('{id}', [DoctorController::class, 'Get']);

});


// search
Route::post('search', [SearchController::class, 'search']);