<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAllProducts($sortBy = 'created_at', $direction = 'desc', $status = 'active')
    {
        return $this->productRepo->getAllProducts($sortBy, $direction, $status);
    }
}