<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LaptopController;     
use App\Http\Controllers\Admin\CriteriaController;   
use App\Http\Controllers\User\HomeController;        
use App\Http\Controllers\User\QuestionController;    
use App\Http\Controllers\User\ResultController;      
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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

// Admin Routes
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Laptop Management
        Route::resource('laptops', LaptopController::class);
        
        // Criteria Management
        Route::get('/criteria/{criteria}/delete', [CriteriaController::class, 'confirmDelete'])->name('criteria.confirm-delete');
        Route::resource('criteria', CriteriaController::class);
        
        // Response Management
        Route::get('responses', [App\Http\Controllers\Admin\ResponseController::class, 'index'])->name('responses.index');
        Route::get('responses/{response}', [App\Http\Controllers\Admin\ResponseController::class, 'show'])->name('responses.show');
    });
});