<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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

Route::get('comment/delete/{id}', [CommentController::class, 'delete'])->name('DeleteComment')->middleware('auth');
Route::post('comment/write/{userId}', [CommentController::class, 'store'])->name('WriteComment')->middleware('auth');

Route::get('user/comments', [CommentController::class, 'userSentComments'])->name('UserComments')->middleware('auth');
