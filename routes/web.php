<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\GalleryController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kavling', [HomeController::class, 'showProduct'])->name('home.product');
Route::get('/layanan', [HomeController::class, 'showServices'])->name('home.services');
Route::get('/portofolio', [HomeController::class, 'showPortofolio'])->name('home.portofolio');
Route::get('/testimoni', [HomeController::class, 'showTestimonials'])->name('home.testimonials');
Route::get('/galeri', [HomeController::class, 'showGallery'])->name('home.Gallery');
Route::get('/artikel', [HomeController::class, 'showArticles'])->name('home.articles');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    Route::prefix('kavling')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    });

    Route::prefix('layanan')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('service.index');
        Route::get('/create', [ServiceController::class, 'create'])->name('service.create');
        Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('service.update');
    });

    Route::prefix('testimoni')->group(function () {
        Route::get('/', [TestimonialController::class, 'index'])->name('testimonial.index');
        Route::get('/create', [TestimonialController::class, 'create'])->name('testimonial.create');
        Route::post('/store', [TestimonialController::class, 'store'])->name('testimonial.store');
        Route::get('/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('testimonial.edit');
        Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('testimonial.update');
    });

    Route::prefix('portofolio')->group(function () {
        Route::get('/', [PortofolioController::class, 'index'])->name('portofolio.index');
        Route::get('/create', [PortofolioController::class, 'create'])->name('portofolio.create');
        Route::post('/store', [PortofolioController::class, 'store'])->name('portofolio.store');
        Route::get('/{portofolio}/edit', [PortofolioController::class, 'edit'])->name('portofolio.edit');
        Route::put('/{portofolio}', [PortofolioController::class, 'update'])->name('portofolio.update');
    });

    Route::prefix('galeri')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
        Route::get('/create', [GalleryController::class, 'create'])->name('gallery.create');
        Route::post('/store', [GalleryController::class, 'store'])->name('gallery.store');
        Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
