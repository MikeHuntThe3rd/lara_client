<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\CityController;

Route::get('/', function() {
    return view('welcome');
});

//==== Auth ====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//==== County ====
Route::get('/counties', [CountyController::class, 'index'])->name('counties.index');

Route::middleware('api.token')->group(function () {
    Route::get('/county', [CountyController::class, 'create'])->name('counties.create');
    Route::get('/county/{id}', [CountyController::class, 'edit'])->name('counties.edit');
    Route::post('/county', [CountyController::class, 'store'])->name('counties.store');
    Route::delete('/county/{id}', [CountyController::class, 'destroy'])->name('counties.destroy');
    Route::patch('/county/{id}', [CountyController::class, 'update'])->name('counties.update');
});

//==== City ====
Route::get('/cities', [CityController::class, 'index'])->name('cities.index');

Route::middleware('api.token')->group(function () {
    Route::get('/city', [CityController::class, 'create'])->name('cities.create');
    Route::get('/city/{id}', [CityController::class, 'edit'])->name('cities.edit');
    Route::post('/city', [CityController::class, 'store'])->name('cities.store');
    Route::delete('/city/{id}', [CityController::class, 'destroy'])->name('cities.destroy');
    Route::patch('/city/{id}', [CityController::class, 'update'])->name('cities.update');
});
