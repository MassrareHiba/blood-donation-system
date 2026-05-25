<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// Public 
Route::get('/blood-stock', [ApiController::class, 'bloodStock']);
Route::get('/donors', [ApiController::class, 'donors']);
Route::get('/appointments', [ApiController::class, 'appointments']);

// Protected API 
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/appointments', [ApiController::class, 'storeAppointment']);
    Route::put('/appointments/{id}', [ApiController::class, 'updateAppointment']);
    Route::delete('/appointments/{id}', [ApiController::class, 'deleteAppointment']);
});