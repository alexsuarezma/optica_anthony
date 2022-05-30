<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessagesController;

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
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => [
            'required',
            'email',
            Rule::exists('users')->where(function ($query) {
                $query->where('active', 1);
            })
        ]
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware(['guest'])->name('password.email');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');


Route::middleware(['auth','verified' ])->prefix('user')->group(function () {
    Route::get('/create', [UserController::class, 'createView'])->name('user.create.admin');
    Route::post('/create', [UserController::class, 'create'])->name('user.create.admin.post');

    Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('/activity/create', [ActivityController::class, 'createView'])->name('activity.create');
    Route::post('/activity/create', [ActivityController::class, 'create'])->name('activity.create.post');
    Route::get('/activity/update/{id}', [ActivityController::class, 'updateView'])->name('activity.update');
    Route::put('/activity/update', [ActivityController::class, 'update'])->name('activity.update.put');
    Route::put('/activity/desaperture', [ActivityController::class, 'departureActivity'])->name('activity.deaperture.update.put');


    Route::put('/information/profile', [UserController::class, 'updateInformationProfile'])->name('user.profile.information.update');

    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::put('/desactive/account', [UserController::class, 'desactiveAccount'])->name('user.desactive.account');
    Route::put('/password', [UserController::class, 'updatePasswordsUsers'])->name('user.passwords.update');
});


Route::middleware(['auth','verified' ])->prefix('order')->group(function () {
    // Route::post('/create', [OrderController::class, 'create'])->name('order.create.post');
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
});

Route::prefix('messages')->group(function () {
    // Route::post('/queue', [MessagesController::class, 'create'])->name('message.create');
});