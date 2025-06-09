<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kavling', [HomeController::class, 'showProduct'])->name('home.product');
Route::get('/layanan', [HomeController::class, 'showServices'])->name('home.services');
Route::get('/portofolio', [HomeController::class, 'showPortofolio'])->name('home.portofolio');
Route::get('/testimoni', [HomeController::class, 'showTestimonials'])->name('home.testimonials');
Route::get('/galeri', [HomeController::class, 'showGallery'])->name('home.Gallery');
Route::get('/artikel', [HomeController::class, 'showArticles'])->name('home.articles');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        // Tambahkan route lain terkait products di sini jika diperlukan
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
