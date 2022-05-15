<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApifedapayController;


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

// FedaPay
Route::any('process', [ApifedapayController::class, 'process'])->name('process');
Route::get('callback', [ApifedapayController::class, 'callback'])->name('callback');
Route::any('invoice', [ApifedapayController::class, 'invoice'])->name('invoice');