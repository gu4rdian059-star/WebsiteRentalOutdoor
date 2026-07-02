<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AlatController;

Route::get('/tes-api', [ApiController::class, 'index']);
Route::apiResource('/alat', AlatController::class);
