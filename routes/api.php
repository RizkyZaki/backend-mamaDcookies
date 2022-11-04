<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client;
use App\Http\Controllers\DashboardController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function ($router) {
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('category', CategoryController::class);
    Route::get('/dashboard', [DashboardController::class, 'index']);
});


// Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::controller(Client::class)->group(function () {
    Route::get('all/product', 'allProduct');
    Route::get('all/category', 'allCategory');
    Route::get('recent/product', 'recentProduct');
    Route::get('search/{keyword}', 'searchProduct');
    Route::get('find/category/{id}', 'CategoryProduct');
    Route::get('detail/product/{id}', 'detailShow');
});
