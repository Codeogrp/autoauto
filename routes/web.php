<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FedapayController;


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

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/activity', function () {
    return view('activity');
});

Route::get('/event', function () {
    return view('event');
});

Route::get('/live', function () {
    return view('live');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/giving', function () {
    return view('giving');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

// FedaPay
Route::any('process', [FedapayController::class, 'process'])->name('process');
Route::get('callback', [FedapayController::class, 'callback'])->name('callback');
Route::any('invoice', [FedapayController::class, 'invoice'])->name('invoice');

