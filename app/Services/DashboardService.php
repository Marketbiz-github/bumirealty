<?php

namespace App\Services;

use App\Repositories\GalleryRepository;
use App\Repositories\PortofolioRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\TestimonialRepository;

class DashboardService
{
    protected $productRepo;
    protected $serviceRepo;
    protected $testimonialRepo;
    protected $portofolioRepo;
    protected $galleryRepo;

    public function __construct(
        ProductRepository $productRepo,
        ServiceRepository $serviceRepo,
        TestimonialRepository $testimonialRepo,
        PortofolioRepository $portofolioRepo,
        GalleryRepository $galleryRepo
    ) {
        $this->productRepo = $productRepo;
        $this->serviceRepo = $serviceRepo;
        $this->testimonialRepo = $testimonialRepo;
        $this->portofolioRepo = $portofolioRepo;
        $this->galleryRepo = $galleryRepo;
    }

    public function getDashboardStats()
    {
        return [
            'products' => $this->productRepo->getTotalCount('active'),
            'services' => $this->serviceRepo->getTotalCount('active'),
            'testimonials' => $this->testimonialRepo->getTotalCount('active'),
            'portofolios' => $this->portofolioRepo->getTotalCount('active'),
            'galleries' => $this->galleryRepo->getTotalCount('active'),
        ];
    }
}