<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RecordController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\UserRecordController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name("login.submit");

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name("register.submit");
});

Route::get('/', [ViewController::class, 'home'])->name('home');
Route::get('/books/{title}', [ViewController::class, 'book_detail'])->name('books.detail');
Route::get('/categories', [ViewController::class, 'categories'])->name('categories');
Route::get('/categories/{name}', [ViewController::class, 'category_detail'])->name('categories.detail');
Route::get('/search', [ViewController::class, 'search'])->name('search');

//Public Auth
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('books/{id}/borrow', [UserRecordController::class, 'showBorrowForm'])->name('borrow.form');
    Route::post('books/{id}/borrow', [UserRecordController::class, 'borrow'])->name('borrow.submit');

    Route::get('books/{id}/return', [UserRecordController::class, 'showReturnForm'])->name('return.form');
    Route::post('books/{id}/return', [UserRecordController::class, 'return'])->name('return.submit');

    Route::get('/profile', [UserRecordController::class, 'showProfile'])->name('profile');
    Route::get('/profile/history', [UserRecordController::class, 'showHistory'])->name('profile.history');
});

//Admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/monitor', [AdminController::class, 'monitor'])->name('admin.monitor');

    // User routes
    Route::resource('users', UserController::class);

    // Rack routes
    Route::resource('racks', RackController::class);

    // Category routes
    Route::resource('categories', CategoryController::class);

    // Book routes
    Route::resource('books', BookController::class);

    // Borrow routes
    Route::resource('records', RecordController::class)->only(["index", "show", "destroy"]);
});