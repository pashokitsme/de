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

// Registration Routes
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Protected Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->get('/home', [HomeController::class, 'dashboard'])->name('dashboard');

// Card Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
    Route::get('/cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
    Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');
    
    // Карточки: управление статусом
    Route::post('/cards/{card}/approve', [CardController::class, 'approve'])->name('cards.approve');
    Route::post('/cards/{card}/reject', [CardController::class, 'reject'])->name('cards.reject');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Card Management
    Route::get('/cards', [AdminController::class, 'index'])->name('cards.index');
    Route::get('/cards/pending', [AdminController::class, 'pending'])->name('cards.pending');
    Route::post('/cards/{card}/approve', [AdminController::class, 'approve'])->name('cards.approve');
    Route::post('/cards/{card}/reject', [AdminController::class, 'reject'])->name('cards.reject');
});
