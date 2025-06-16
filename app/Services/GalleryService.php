<?php

namespace App\Services;

use App\Repositories\GalleryRepository;
use Illuminate\Support\Str;

class GalleryService
{
    protected $galleryRepo;
    protected $mediaService;

    public function __construct(
        GalleryRepository $galleryRepo,
        MediaService $mediaService
    ) {
        $this->galleryRepo = $galleryRepo;
        $this->mediaService = $mediaService;
    }

    public function getGallery($status = 'active')
    {
        return $this->galleryRepo->getAllGallery($status);
    }

    public function store($data, $image)
    {
        try {
            $galleryId = Str::uuid();
            
            // Upload image
            $media = $this->mediaService->uploadImage(
                $image,
                'gallery',
                $galleryId,
                false
            );

            // Update media name
            $this->galleryRepo->update($media->id, [
                'name' => $data['name']
            ]);

            return $media;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findById($id)
    {
        return $this->galleryRepo->findById($id);
    }

    public function update($id, $data, $newImage = null)
    {
        try {
            $gallery = $this->galleryRepo->findById($id);
            if (!$gallery) {
                throw new \Exception('Gallery not found');
            }

            // Handle new image upload if provided
            if ($newImage) {
                $media = $this->mediaService->uploadImage(
                    $newImage,
                    'gallery',
                    $gallery->usage_id,
                    false
                );

                // Delete old image
                $this->mediaService->deleteImage($id);

                // Update with new image data
                $this->galleryRepo->update($media->id, [
                    'name' => $data['name'],
                    'status' => $data['status']
                ]);

                return $media;
            }

            // Just update the data without changing image
            $this->galleryRepo->update($id, [
                'name' => $data['name'],
                'status' => $data['status']
            ]);

            return $gallery;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete($id)
    {
        return $this->galleryRepo->delete($id);
    }
}