<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('users', [UserController::class, 'index'])->name('Users');

Route::get('profile/{id?}', [UserController::class, 'profile'])->name('Profile');

Route::prefix('comment')->group(function () {
    Route::get('/delete/{id}', [CommentController::class, 'delete'])->name('DeleteComment')->middleware('auth');
    Route::post('/write/{userId}', [CommentController::class, 'store'])->name('WriteComment')->middleware('auth');
});

Route::prefix('user')->group(function () {
    Route::get('/comments', [CommentController::class, 'userSentComments'])->name('UserComments')->middleware('auth');
    Route::get('/{id}/books', [BookController::class, 'getUserBooks'])->name('UserBooks')->middleware('auth');
    Route::get('/{id}/access', [BookController::class, 'changeLibraryAccess'])->name('ChangeLibraryAccess')->middleware('auth');
});

Route::prefix('book')->group(function () {
    Route::post('/create/{userId}', [BookController::class, 'store'])->name('CreateBook')->middleware('auth');
    Route::post('/edit/{id}', [BookController::class, 'edit'])->name('EditBook')->middleware('auth');
    Route::get('/delete/{id}', [BookController::class, 'delete'])->name('DeleteBook')->middleware('auth');
    Route::get('/share/{id}', [BookController::class, 'shareBook'])->name('ShareBook')->middleware('auth');
    Route::get('/{id}', [BookController::class, 'getBook'])->name('Book')->middleware('books.access');
});
