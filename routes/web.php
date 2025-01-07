<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\StoreAuthMiddleware;
use Illuminate\Support\Facades\Route;

// Sobudomain Routes Stores
Route::domain('{subdomain}.localhost')->group(function(){
    Route::get('/', [\App\Http\Controllers\Front\StoreController::class, 'index'])
            ->name('front.store');

    Route::prefix('cart')->name('cart.')->group(function(){
        Route::get('/', [\App\Http\Controllers\Front\CartController::class, 'index'])->name('index');
        Route::get('add/{product}', [\App\Http\Controllers\Front\CartController::class, 'add'])->name('add');
        Route::get('remove/{product}', [\App\Http\Controllers\Front\CartController::class, 'remove'])->name('remove');
        Route::get('cancel', [\App\Http\Controllers\Front\CartController::class, 'cancel'])->name('cancel');
    });

    Route::prefix('checkout')->middleware([StoreAuthMiddleware::class])->name('checkout.')->group(function(){
        Route::get('/', [\App\Http\Controllers\Front\CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/proccess', [\App\Http\Controllers\Front\CheckoutController::class, 'proccess'])->name('proccess');
        Route::get('/thanks', [\App\Http\Controllers\Front\CheckoutController::class, 'thanks'])->name('thanks');
    });

    Route::name('sign.')->group(function() {
        Route::get('/sign-in', [\App\Http\Controllers\Front\AuthenticateController::class, 'index'])->name('index');
        Route::post('/sign-in', [\App\Http\Controllers\Front\AuthenticateController::class, 'signIn'])->name('in');
        Route::post('/sign-up', [\App\Http\Controllers\Front\AuthenticateController::class, 'signUp'])->name('up');
    });
    Route::get('logout', [\App\Http\Controllers\Front\AuthenticateController::class, 'logout'])->name('up');

});

Route::get('/', function () {
    dump(\App\Models\Store::where('tenant_id', session()->get('tenant'))->first());
    return view('welcome');
});

Route::get('/dashboard', function () {    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function(){
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
