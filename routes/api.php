<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventarisController;

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
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::put('/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/inventaris', [InventarisController::class, 'tambahInventaris']);
    Route::put('/inventaris', [InventarisController::class, 'updateInventaris']);
    Route::delete('/inventaris', [InventarisController::class, 'hapusInventaris']);
    Route::get('/inventaris', [InventarisController::class, 'listInventaris']);
    Route::get('/inventaris/{id}', [InventarisController::class, 'inventarisById']);
});
