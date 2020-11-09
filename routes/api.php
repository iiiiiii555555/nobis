<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('services_categories',\App\Http\Controllers\CategoryController::class);
Route::get('login',function (){
    return response()->json(['msg'=>'Unauthorized'],401);
})->name('login');

Route::post('register','App\Http\Controllers\UserController@register')->name('register');
Route::post('signin','App\Http\Controllers\UserController@signin')->name('signin');
