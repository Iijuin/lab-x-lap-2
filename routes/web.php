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
use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Routes
Route::prefix('questions')->name('questions.')->group(function () {
    Route::get('/', [QuestionController::class, 'index'])->name('index');
    Route::post('/submit', [QuestionController::class, 'store'])->name('store');
    Route::get('/options', [QuestionController::class, 'getFormOptions'])->name('options');
});

Route::prefix('results')->name('results.')->group(function () {
    Route::get('/', [ResultController::class, 'index'])->name('index');
    Route::get('/{id}', [ResultController::class, 'show'])->name('show');
});

// Tambahkan route untuk user.form
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/form', [UserController::class, 'form'])->name('form');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Route untuk halaman admin yang belum login
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route yang membutuhkan autentikasi admin
    Route::middleware(['auth', 'admin'])->group(function () {
        // Laptop Management
        Route::resource('laptops', LaptopController::class);
        Route::post('laptops/{laptop}/toggle-status', [LaptopController::class, 'toggleStatus'])->name('laptops.toggle-status');
        
        // Criteria Management
        Route::get('/criteria', [CriteriaController::class, 'index'])->name('criteria.index');
        
        // Response Management
        Route::get('responses', [ResponseController::class, 'index'])->name('responses.index');
        Route::get('responses/{response}', [ResponseController::class, 'show'])->name('responses.show');
    });
});

// Password Reset Routes
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');