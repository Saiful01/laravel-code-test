<?php

use App\Http\Controllers\Controller;
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

Route::get('/', function () {
    return view('registration');
});
Route::post('/registration/otp-sent', [Controller::class, 'otpSent']);
Route::post('/registration/save', [Controller::class, 'registrationSave']);

Route::get('/login', [Controller::class, 'login']);
Route::post('/login-check', [Controller::class, 'LoginCheck']);
Route::get('/logout', [Controller::class, 'adminLogout']);

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::any('/dashboard', [Controller::class, 'adminDashboard']);

});
Route::group(['prefix' => 'agent', 'middleware' => 'agent'], function () {
    Route::any('/dashboard', [Controller::class, 'agentDashboard']);

});
Route::group(['prefix' => 'user', 'middleware' => 'agent'], function () {
    Route::any('/dashboard', [Controller::class, 'userDashboard']);

});

