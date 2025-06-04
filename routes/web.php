<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LaptopController;     
use App\Http\Controllers\Admin\CriteriaController;   
use App\Http\Controllers\User\HomeController;        
use App\Http\Controllers\User\QuestionController;    
use App\Http\Controllers\User\ResultController;      
use App\Http\Controllers\User\UserController; // Import UserController

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('questions')->name('questions.')->group(function () {
    Route::get('/', [QuestionController::class, 'index'])->name('index');
    Route::post('/submit', [QuestionController::class, 'store'])->name('store');
    Route::get('/options', [QuestionController::class, 'getFormOptions'])->name('options');
});

// Tambahkan route untuk results
Route::prefix('results')->name('results.')->group(function () {
    Route::get('/', [ResultController::class, 'index'])->name('index');
    Route::get('/{id}', [ResultController::class, 'show'])->name('show');
});

// Tambahkan route untuk user.form
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/form', [UserController::class, 'form'])->name('form');
});

// Rute admin
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::resource('laptops', LaptopController::class);
    Route::resource('criteria', CriteriaController::class);
});