<?php
namespace App\Services;

use App\Repositories\PortofolioRepository;
use App\Services\MediaService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PortofolioService
{
    protected $portofolioRepo;
    protected $mediaService;

    public function __construct(PortofolioRepository $portofolioRepo, MediaService $mediaService)
    {
        $this->portofolioRepo = $portofolioRepo;
        $this->mediaService = $mediaService;
    }

    public function getPortofolios($status = 'active')
    {
        return $this->portofolioRepo->getAllPortofolios($status);
    }

    public function store($data, $thumbnail, $images)
    {
        try {
            DB::beginTransaction();

            // Create portofolio
            $portofolio = $this->portofolioRepo->create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'status' => 'active'
            ]);

            // Handle thumbnail
            if ($thumbnail) {
                $thumbnailMedia = $this->mediaService->uploadImage(
                    $thumbnail,
                    'portofolio',
                    $portofolio->id,
                    true
                );
                
                $this->portofolioRepo->update($portofolio->id, [
                    'thumbnail_id' => $thumbnailMedia->id
                ]);
            }

            // Handle additional images
            foreach ($images as $image) {
                $this->mediaService->uploadImage(
                    $image,
                    'portofolio',
                    $portofolio->id,
                    false
                );
            }

            DB::commit();
            return $portofolio;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findById($id)
    {
        $portofolio = $this->portofolioRepo->findById($id);
        if (!$portofolio) return null;

        // Get all related media
        $media = DB::table('media_files')
            ->where('usage_type', 'portofolio')
            ->where('usage_id', $id)
            ->where('status', 'active')
            ->get();

        $portofolio->images = $media->where('is_main', false)->values();
        $portofolio->thumbnail = $media->firstWhere('is_main', true);

        return $portofolio;
    }

    public function update($id, $data, $thumbnail = null, $images = [], $deletedImages = [])
    {
        try {
            DB::beginTransaction();

            // Update basic info
            $portofolio = $this->portofolioRepo->update($id, [
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'status' => $data['status']
            ]);

            // Handle deleted images
            if (!empty($deletedImages)) {
                foreach ($deletedImages as $mediaId) {
                    $this->mediaService->deleteImage($mediaId);
                }
            }

            // Handle thumbnail if provided
            if ($thumbnail) {
                // Delete old thumbnail
                if ($portofolio->thumbnail_id) {
                    $this->mediaService->deleteImage($portofolio->thumbnail_id);
                }

                // Upload new thumbnail
                $thumbnailMedia = $this->mediaService->uploadImage(
                    $thumbnail,
                    'portofolio',
                    $id,
                    true
                );
                
                $this->portofolioRepo->update($id, [
                    'thumbnail_id' => $thumbnailMedia->id
                ]);
            }

            // Handle additional images
            foreach ($images as $image) {
                $this->mediaService->uploadImage(
                    $image,
                    'portofolio',
                    $id,
                    false
                );
            }

            DB::commit();
            return $portofolio;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}