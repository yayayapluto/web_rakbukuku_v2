<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RecordController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Route;

//Public
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);

// Route::get('/', [BookController::class, 'index'])->name('home');
// Route::get('/books/{uuid}', [BookController::class, 'show'])->name('books.show');
// Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
// Route::get('/categories/{uuid}', [CategoryController::class, 'show'])->name('categories.show');

// //Public Auth
// Route::middleware(['auth'])->group(function () {
//     Route::get('/borrow/{uuid}', [RecordController::class, 'confirmBorrow'])->name('borrow.confirm');
//     Route::post('/borrow/{uuid}', [RecordController::class, 'borrow'])->name('borrow.store');
//     Route::get('/return/{uuid}', [RecordController::class, 'confirmReturn'])->name('return.confirm');
//     Route::post('/return/{uuid}', [RecordController::class, 'return'])->name('return.store');

//     Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
//     Route::get('/profile/borrowed', [UserController::class, 'borrowed'])->name('profile.borrowed');
//     Route::get('/profile/history', [UserController::class, 'history'])->name('profile.history');
// });

// //Admin
// Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
//     Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::get('/monitor', [AdminController::class, 'monitor'])->name('admin.monitor');

//     // User routes
//     Route::resource('users', UserController::class);

//     // Book routes
//     Route::resource('books', BookController::class);

//     // Category routes
//     Route::resource('categories', CategoryController::class);

//     // Borrow routes
//     Route::get('borrows', [RecordController::class, 'index'])->name('admin.borrows.index');
//     Route::get('borrows/{id}', [RecordController::class, 'show'])->name('admin.borrows.show');
//     Route::delete('borrows/{id}', [RecordController::class, 'returnBook'])->name('admin.borrows.return');
//     Route::resource('borrows', CategoryController::class)->only(["index", "show", "destroy"]);


//     // Rack routes
//     Route::resource('racks', RackController::class);
// });