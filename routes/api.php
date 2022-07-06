<?php

use App\Http\Controllers\API\ListAplikasiController;
use App\Http\Controllers\Api\TokenController;
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

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});

Route::prefix('list')->group(function(){
    Route::get('/all', [ListAplikasiController::class, 'index']);
    Route::post('/tambah', [ListAplikasiController::class, 'store']);
    Route::get('/aplikasi/{id}', [ListAplikasiController::class, 'show']);
    Route::put('/update/{id}', [ListAplikasiController::class, 'update']);
    Route::delete('/delete/{id}', [ListAplikasiController::class, 'destroy']);
});

Route::prefix('token')->group(function(){
    Route::get('/all', [TokenController::class, 'index']);
    Route::post('/tambah', [TokenController::class, 'store']);
});