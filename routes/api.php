<?php

use App\Http\Controllers\API_AuthController;
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::post('login', [API_AuthController::class, 'login']);
    Route::post('login/guru', [API_AuthController::class, 'login_guru']);
    Route::post('logout', [API_AuthController::class, 'logout']);
    Route::post('register', [API_AuthController::class, 'register']);
    Route::post('refresh', [API_AuthController::class, 'refresh']);
    Route::post('me', [API_AuthController::class, 'userProfile']);
    Route::post('update-profile', [API_AuthController::class, 'updateProfile']);
    Route::post('update-profile-picture', [API_AuthController::class, 'updateProfilePicture']);

});

Route::post('encode', [APIController::class, 'encode']);
Route::post('validate-password', [APIController::class, 'hashcheck']);
Route::get('getBidangKompetensi', [APIController::class, 'getBidangKompetensi']);

Route::get('praktik-baik', [APIController::class, 'get_praktik_baik']);
Route::get('praktik-baik/detail/{slug}', [APIController::class, 'detail_praktik_baik']);


// Route::controller(API_AuthController::class)->prefix('auth')->group(function () {
//     Route::post('login', 'login');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');
//     Route::get('me', 'me');

// });
