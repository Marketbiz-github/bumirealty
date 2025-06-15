<?php
namespace App\Services;

use App\Repositories\ServiceRepository;
use Illuminate\Support\Str;

class ServiceService
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getAll($status = null)
    {
        return $this->serviceRepository->getAllServices($status);
    }

    public function find($id)
    {
        return $this->serviceRepository->findById($id);
    }

    public function update($id, $data)
    {
        return $this->serviceRepository->update($id, $data);
    }
    
    public function create($data)
    {
        // Generate UUID for new service
        $data['id'] = Str::uuid()->toString();
        
        // Generate slug from title
        $data['slug'] = Str::slug($data['title']);
        
        // Set default values if not provided
        $data['status'] = $data['status'] ?? 'active';
        $data['created_at'] = now();
        $data['updated_at'] = now();

        return $this->serviceRepository->create($data);
    }
}