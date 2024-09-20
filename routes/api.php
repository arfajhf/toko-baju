<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('roles:admin')->prefix('admin')->group(function(){
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::controller(AdminController::class)->group(function(){
            Route::prefix('inventaris')->group(function(){
                Route::get('/', 'inventaris');
                Route::post('/create', 'inventarisCreate');
                Route::get('/show/{id}', 'inventarisShow');
            });
            Route::prefix('kasir')->group(function(){
                Route::get('/', 'kasir');
                Route::post('/create', 'kasirCreate');
                Route::get('/show/{id}', 'kasirShow');
            });
        });
    });

    Route::middleware('roles:inventaris')->prefix('inventaris')->group(function(){
        Route::get('/', function(){
            return 'ini inventaris';
        });
    });
    Route::middleware('roles:kasir')->prefix('kasir')->group(function(){
        Route::get('/', function(){
            return 'ini kasir';
        });
    });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
