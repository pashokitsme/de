<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('debug-login', [AuthController::class, 'debugLogin'])->name('debug-login');

// Registration Routes
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Protected Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->get('/home', [HomeController::class, 'dashboard'])->name('dashboard');

// Card Routes
Route::prefix('/cards')->name('cards.')->group(function () {
    Route::get('/', [CardController::class, 'index'])->name('index');
    Route::get('/create', [CardController::class, 'create'])->name('create');
    Route::post('/', [CardController::class, 'store'])->name('store');
    Route::delete('/{card}', [CardController::class, 'destroy'])->name('destroy');
    
    // Карточки: управление статусом
    Route::post('/{card}/approve', [CardController::class, 'approve'])->name('approve');
    Route::post('/{card}/reject', [CardController::class, 'reject'])->name('reject');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Card Management
    Route::get('/cards', [AdminController::class, 'index'])->name('cards.index');
    Route::get('/cards/pending', [AdminController::class, 'pending'])->name('cards.pending');
    Route::post('/cards/{card}/approve', [AdminController::class, 'approve'])->name('cards.approve');
    Route::post('/cards/{card}/reject', [AdminController::class, 'reject'])->name('cards.reject');
});
