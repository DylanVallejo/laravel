<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\Api\studentController;


Route::get('/students', [studentController::class,'index']);


Route::get('/student/{id}', [studentController::class,'show']);

Route::post('/student',  [studentController::class,'store']);

Route::put('/student/{id}',[studentController::class,'update']);

Route::patch('/student/{id}',[studentController::class,'patch']);

Route::delete('/student/{id}', [studentController::class,'delete']);
