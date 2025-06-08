<?php
namespace App\Services;

use App\Repositories\ServiceRepository;

class ServiceService
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getServices($status = 'active')
    {
        return $this->serviceRepository->getAllServices($status);
    }
}