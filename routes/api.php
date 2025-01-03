<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReportController;

Route::post('/reports', [ReportController::class, 'store']);
Route::get('/reports', [ReportController::class, 'index']);
Route::patch('/reports/{id}', [ReportController::class, 'update']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
