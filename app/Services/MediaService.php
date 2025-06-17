<?php

namespace App\Services;

use App\Repositories\MediaRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    protected $mediaRepository;

    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function uploadImage(UploadedFile $file, string $type, string $usageId, bool $isMain = false)
    {
        try {
            $path = $file->store('images/products', 'public');

            // Determine base URL based on environment
            if (app()->environment('production')) {
                $baseUrl = 'https://app.bumirealty.id/public/storage';
            } else {
                $baseUrl = asset('storage');
            }

            $url = $baseUrl . '/' . $path;

            // Log complete data that will be inserted
            Log::info('Preparing media data for insert', [
                'url' => $url,
                'usage_type' => $type,
                'usage_id' => $usageId,
                'is_main' => $isMain,
                'status' => 'active'
            ]);

            $media = $this->mediaRepository->create([
                'url' => $url,
                'usage_type' => $type,
                'usage_id' => $usageId,
                'is_main' => $isMain,
                'status' => 'active'
            ]);

            return $media;
        } catch (\Exception $e) {
            // Clean up uploaded file if exists
            if ($path && Storage::exists($path)) {
                Storage::delete($path);
            }

            Log::error('Failed to upload image', [
                'usage_id' => $usageId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function deleteImage($mediaId)
    {
        $this->mediaRepository->delete($mediaId);
    }
}