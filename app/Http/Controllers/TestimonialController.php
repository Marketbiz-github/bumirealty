<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\SettingService;
use Illuminate\Support\Facades\Log;

class testimonialController extends Controller
{
    protected $productService;
    protected $settingService;

    protected $settings;

    public function __construct(
        ProductService $productService,
        SettingService $settingService,
    ) {
        $this->productService = $productService;
        $this->settingService = $settingService;

        // Inisialisasi data utama
        $this->settings = $this->settingService->getSettings();
    }

    public function index()
    {
        return view('dashboard.testimonial', [
            'products' => $this->productService->getAllProducts('updated_at', 'desc', null),
            'settings' => $this->settings,
        ]);
    }
}