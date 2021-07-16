<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductController;
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
//public route
Route::get('/products',[ProductController::Class,'index']);
Route::get('/products/{id}',[ProductController::Class,'show']);
Route::post("/register",[UserController::class,'register']);
Route::post("/login",[UserController::class,'login']);
//Authenticate Route group
Route::group(['middleware'=>['auth:sanctum']],function(){
Route::post('/products',[ProductController::Class,'store']);
Route::post('/products/{id}',[ProductController::Class,'update']);
Route::delete('/products/{id}',[ProductController::Class,'destroy']);
Route::post('logout',[UserController::Class,'logout']);

});