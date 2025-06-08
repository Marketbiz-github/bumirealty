<?php
namespace App\Services;

use App\Repositories\GalleryRepository;

class GalleryService
{
    protected $galleryRepo;

    public function __construct(GalleryRepository $galleryRepo)
    {
        $this->galleryRepo = $galleryRepo;
    }

    public function getGallery($status = 'active')
    {
        return $this->galleryRepo->getAllGallery($status);
    }
}