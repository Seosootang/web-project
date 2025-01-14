<?php

use Illuminate\Auth\Middleware\Authenticate; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) { 
return $request->user(); 
})->middleware(Authenticate::using('sanctum')); 

//packages 
Route::apiResource('/packages', App\Http\Controllers\Api\PackageController::class); 
Route::apiResource('/reservations', App\Http\Controllers\Api\ReservationController::class); 
Route::apiResource('/carrents', App\Http\Controllers\Api\CarRentController::class); 
Route::apiResource('/busrents', App\Http\Controllers\Api\BusRentController::class); 
Route::apiResource('/accounts', App\Http\Controllers\Api\AccountController::class); 
