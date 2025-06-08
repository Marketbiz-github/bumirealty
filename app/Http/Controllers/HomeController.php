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
    }

    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productService->getAllProducts('created_at', 'desc', 'active');
        $settings = $this->settingService->getSettings();
        $services = $this->serviceService->getServices('active');
        $testimonials = $this->testimonialService->getTestimonials('active');
        $portofolios = $this->portofolioService->getPortofolios('active');
        $gallery = $this->galleryService->getGallery('active'); 
        $articles = $this->articleService->getLatestArticles(4);

        return view('home', compact('products', 'settings', 'services', 'testimonials', 'portofolios', 'gallery', 'articles'));
    }
}
