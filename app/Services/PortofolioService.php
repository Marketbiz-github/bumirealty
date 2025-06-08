<?php
namespace App\Services;

use App\Repositories\PortofolioRepository;

class PortofolioService
{
    protected $portofolioRepo;

    public function __construct(PortofolioRepository $portofolioRepo)
    {
        $this->portofolioRepo = $portofolioRepo;
    }

    public function getPortofolios($status = 'active')
    {
        return $this->portofolioRepo->getAllPortofolios($status);
    }
}