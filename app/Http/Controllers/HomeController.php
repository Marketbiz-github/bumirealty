<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\SettingService;
use App\Services\ServiceService;
use App\Services\TestimonialService;
use App\Services\PortofolioService;
use App\Services\GalleryService; 
use App\Services\ArticleService;

class HomeController extends Controller
{
    protected $productService;
    protected $settingService;
    protected $serviceService;
    protected $testimonialService;
    protected $portofolioService;
    protected $galleryService;
    protected $articleService;

    // Tambahkan property data
    protected $products;
    protected $settings;
    protected $services;
    protected $portofolios;

    public function __construct(
        ProductService $productService,
        SettingService $settingService,
        ServiceService $serviceService,
        TestimonialService $testimonialService,
        PortofolioService $portofolioService,
        GalleryService $galleryService,
        ArticleService $articleService
    ) {
        $this->productService = $productService;
        $this->settingService = $settingService;
        $this->serviceService = $serviceService;
        $this->testimonialService = $testimonialService;
        $this->portofolioService = $portofolioService;
        $this->galleryService = $galleryService;
        $this->articleService = $articleService;

        // Inisialisasi data utama
        $this->products = $this->productService->getAllProducts('updated_at', 'desc', 'active');
        $this->settings = $this->settingService->getSettings();
        $this->services = $this->serviceService->getAll('active');
        $this->portofolios = $this->portofolioService->getPortofolios('active');
    }

    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = $this->testimonialService->getTestimonials('active');
        $gallery = $this->galleryService->getGallery('active');
        $articles = $this->articleService->getLatestArticles(4);

        return view('home', [
            'products' => $this->products,
            'settings' => $this->settings,
            'services' => $this->services,
            'testimonials' => $testimonials,
            'portofolios' => $this->portofolios,
            'gallery' => $gallery,
            'articles' => $articles,
        ]);
    }

    public function showProduct()
    {
        return view('kavling', [
            'products' => $this->products,
            'settings' => $this->settings,
            'services' => $this->services,
            'portofolios' => $this->portofolios,
        ]);
    }

    public function showPortofolio()
    {
        return view('portofolio', [
            'products' => $this->products,
            'settings' => $this->settings,
            'services' => $this->services,
            'portofolios' => $this->portofolios,
        ]);
    }

    public function showServices()
    {
        return view('services', [
            'products' => $this->products,
            'settings' => $this->settings,
            'services' => $this->services,
            'portofolios' => $this->portofolios,
        ]);
    }

    public function showTestimonials()
    {
        $testimonials = $this->testimonialService->getTestimonials('active');

        return view('testimonials', [
            'products' => $this->products,
            'settings' => $this->settings,
            'services' => $this->services,
            'testimonials' => $testimonials,
            'portofolios' => $this->portofolios,
        ]);
    }

    public function showGallery()
    {
        $gallery = $this->galleryService->getGallery('active');

        return view('gallery', [
            'products' => $this->products,
            'settings' => $this->settings,
            'services' => $this->services,
            'portofolios' => $this->portofolios,
            'gallery' => $gallery,
        ]);
    }

    public function showArticles()
    {
        return redirect()->away('https://marketbiz.net');
    }
}
