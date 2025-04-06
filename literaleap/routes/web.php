<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscribeController;
use Laravel\Cashier\Http\Controllers\WebhookController;
use App\Models\Post;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;

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
    Route::delete('/forum/{post}', [ForumController::class, 'destroy'])->name('forum.destroy');

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

Route::middleware(['auth'])->group(function () {
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::post('/teams/invite/{team}', [TeamController::class, 'invite'])->name('teams.invite');
    Route::post('/teams/join', [TeamController::class, 'joinByCode'])->name('teams.join');
    Route::post('/teams/invitation/{pivotId}', [TeamController::class, 'respondInvitation'])->name('teams.respondInvitation');
    Route::get('/teams/{team}/manage', [TeamController::class, 'manage'])->name('teams.manage');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}/members/{user}', [TeamController::class, 'removeMember'])->name('teams.removeMember');
});

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/shop/item/{id}', [ShopController::class, 'show'])->name('shop.item.show');

Route::get('/test-gd', function () {
    dd(extension_loaded('gd'));
});

Route::middleware(['auth'])->group(function () {
    Route::get('/subscribe', function () {
        return view('subscribe');
    })->name('subscribe');

    Route::post('/subscribe/checkout', [SubscribeController::class, 'checkout'])->name('subscribe.checkout');

    Route::get('/subscribe/success', [SubscribeController::class, 'success'])->name('subscribe.success');
    Route::get('/subscribe/cancel', [SubscribeController::class, 'cancel'])->name('subscribe.cancel');
});

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])
->name('stripe.webhook');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/games/{game}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/games/{game}/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/games/{game}/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/games/{game}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::get('/premium-assets/coin_clicker.js', function () {
    if (!Auth::check() || !Auth::user()->premium) {
        abort(403, 'Unauthorized access to premium asset.');
    }

    $path = resource_path('premium-js/coin_clicker.js');

    return response()->file($path, [
        'Content-Type' => 'application/javascript'
    ]);
})->name('premium.coinclicker.js');

require __DIR__.'/auth.php';