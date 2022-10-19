<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route group for the blog controller with middleware
Route::middleware('auth:api')->group(function () {
    Route::controller(BlogController::class)->group(function () {
        Route::get('blogs', 'index');
        Route::post('blogs', 'create');
        Route::put('blogs/{id}', 'update');
        Route::delete('blogs/{id}', 'destroy');
        Route::get('users', 'users');
        Route::put('like/increment/{id}', 'like');
        Route::put('like/decrement/{id}', 'unlike');
        Route::put('dislike/increment/{id}', 'dislike');
        Route::put('dislike/decrement/{id}', 'undislike');
        Route::get('userblog', 'userblog');
        Route::get('userblog/{id}', 'singleuserblog');
    });
});
