<?php

use App\Http\Controllers\ClaimApiController;
use App\Http\Controllers\SppaApiController;
use App\Http\Controllers\SppaController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('list/{api_key}', [SppaApiController::class, 'list']);
Route::post('/check/{api_key}', [SppaApiController::class, 'check']);
Route::post('entries/{api_key}', [SppaApiController::class, 'store']);
Route::post('payment/{api_key}', [SppaApiController::class, 'pembayaran']);
Route::get('view/{id}/{api_key}', [SppaApiController::class, 'show']);


Route::post('claim/{api_key}', [ClaimApiController::class, 'submit']);
Route::get('claim/list/{api_key}', [ClaimApiController::class, 'all']);
Route::get('claim/show/{id}/{api_key}', [ClaimApiController::class, 'show']);
