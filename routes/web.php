<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Sobudomain Routes Stores
Route::domain('{subdomain}.localhost')->group(function(){
    Route::get('/', [\App\Http\Controllers\Front\StoreController::class, 'index'])
            ->name('front.store');
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
