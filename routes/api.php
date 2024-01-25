<?php

use App\Http\Controllers\OwnerController;
use App\Http\Controllers\VehicleController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//Grupo de rotas owners
Route::prefix('/owners')->group(function () {
    Route::get('/', [OwnerController::class, 'index']);
    Route::get('/show/{id}', [OwnerController::class, 'show']);
    Route::post('/store', [OwnerController::class, 'store']);
    Route::put('/update/{id}', [OwnerController::class, 'update']);
    Route::delete('/delete/{id}', [OwnerController::class, 'destroy']);
    Route::post('/vehicles', [OwnerController::class, 'getVehiclesByOwner']);
    Route::get('/gender/vehicles', [OwnerController::class, 'getCountVehiclesByGender']);
});

//Grupo de rotas vehicles
Route::prefix('/vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index']);
    Route::get('/show/{id}', [VehicleController::class, 'show']);
    Route::post('/store', [VehicleController::class, 'store']);
    Route::put('/update/{id}', [VehicleController::class, 'update']);
    Route::delete('/delete/{id}', [VehicleController::class, 'destroy']);
});
