<?php

use App\Http\Controllers\SalaryApiController;
use Illuminate\Support\Facades\Route;

Route::post('/salaries/calculate', [SalaryApiController::class, 'calculate'])
    ->name('api.salaries.calculate');