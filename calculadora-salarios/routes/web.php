<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalaryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/salarios', [SalaryController::class, 'create'])
    ->name('salaries.create');

Route::post('/salarios', [SalaryController::class, 'calculate'])
    ->name('salaries.calculate');
