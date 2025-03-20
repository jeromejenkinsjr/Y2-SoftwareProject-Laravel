<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Auth\GoogleController;

use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update-picture');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
});

Route::post('/shop/buy-item/{item}', [ShopController::class, 'buyItem'])->name('shop.buyItem');

Route::middleware(['auth'])->group(function () {
    Route::post('/add-credit', [GameController::class, 'addCredit']);
});

Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/{post}/reply', [ForumController::class, 'reply'])->name('forum.reply');
        Route::post('/forum/{post}/like', [ForumController::class, 'like'])->name('forum.like');
    Route::post('/forum/{post}/dislike', [ForumController::class, 'dislike'])->name('forum.dislike');
});
Route::middleware('guest')->group(function () {
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');
});

Route::get('/termsprivacy', function () {
    return view('termsprivacy');
})->name('termsprivacy');

Route::post('/profile/update-icon', [ProfileController::class, 'updateIcon'])->name('profile.updateIcon');


Route::get('/test-gd', function () {
    dd(extension_loaded('gd'));
});

require __DIR__.'/auth.php';