<?php

use App\Http\Controllers\ClaimContoller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SppaApiController;
use App\Http\Controllers\SppaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('dashboard', [DashboardController::class, 'view']);
Route::get('/', [SppaController::class, 'view']);
Route::get('/akseptasi/{Y}/{id}', [SppaController::class, 'akseptasi'])->name('akseptasi');
Route::get('/show/{id}', [SppaController::class, 'show']);
Route::get('print/{id}', [SppaApiController::class, 'printPolis']);
Route::get('/claim', [ClaimContoller::class, 'view']);
Route::get('/claim/{id}', [ClaimContoller::class, 'show']);
Route::get('/claim/{Y}/{id}', [ClaimContoller::class, 'akseptasi'])->name('akseptasi');
