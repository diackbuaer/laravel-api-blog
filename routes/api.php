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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/test', function (){
   return response([
       'message' => 'API message'
   ], 200);
});

Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'feed'], function (){
   Route::post('store', [\App\Http\Controllers\Api\FeedController::class, 'store']);
   Route::post('like/{id}', [\App\Http\Controllers\Api\FeedController::class, 'likePost']);
   Route::post('comment/{id}', [\App\Http\Controllers\Api\FeedController::class, 'comment']);
   Route::get('comments/{id}', [\App\Http\Controllers\Api\FeedController::class, 'getComments']);
});

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::get('/feeds', [\App\Http\Controllers\Api\FeedController::class, 'index']);
});

