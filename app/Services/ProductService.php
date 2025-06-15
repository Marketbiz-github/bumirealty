<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Services\MediaService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    protected $productRepository;
    protected $mediaService;

    public function __construct(
        ProductRepository $productRepository,
        MediaService $mediaService
    ) {
        $this->productRepository = $productRepository;
        $this->mediaService = $mediaService;
    }

    public function getAllProducts($sortBy = 'created_at', $direction = 'desc', $status)
    {
        return $this->productRepository->getAllProducts($sortBy, $direction, $status);
    }

    public function store(array $data, $thumbnail = null, $images = [])
    {
        try {
            DB::beginTransaction();

            // Generate slug
            $data['slug'] = Str::slug($data['name']);
            
            // Create product first
            $product = $this->productRepository->create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'price' => $data['price'],
                'description' => $data['description'] ?? null,
                'status' => 'active'
            ]);

            // Handle thumbnail
            if ($thumbnail) {
                try {
                    $thumbnailMedia = $this->mediaService->uploadImage(
                        $thumbnail, 
                        'product', 
                        $product->id, 
                        true
                    );
                    
                    $this->productRepository->update($product->id, [
                        'thumbnail_id' => $thumbnailMedia->id
                    ]);

                    Log::info('Thumbnail uploaded', [
                        'product_id' => $product->id,
                        'media_id' => $thumbnailMedia->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to upload thumbnail', [
                        'product_id' => $product->id,
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
            }

            // Handle multiple images
            if (!empty($images)) {
                foreach ($images as $index => $image) {
                    try {
                        $this->mediaService->uploadImage(
                            $image, 
                            'product', 
                            $product->id, 
                            false
                        );
                        Log::info('Additional image uploaded', [
                            'product_id' => $product->id,
                            'index' => $index
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to upload additional image', [
                            'product_id' => $product->id,
                            'index' => $index,
                            'error' => $e->getMessage()
                        ]);
                        throw $e;
                    }
                }
            }

            // Store attributes
            if (isset($data['attributes'])) {
                try {
                    $this->productRepository->syncAttributes($product->id, $data['attributes']);
                    Log::info('Product attributes synced', [
                        'product_id' => $product->id,
                        'attributes' => $data['attributes']
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to sync attributes', [
                        'product_id' => $product->id,
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
            }

            DB::commit();

            return $product;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function findById($id)
    {
        return $this->productRepository->findById($id);
    }

    public function update($id, array $data, $thumbnail = null, $images = [])
    {
        try {
            DB::beginTransaction();

            // Generate slug
            $data['slug'] = Str::slug($data['name']);

            // Update product
            $product = $this->productRepository->update($id, [
                'name' => $data['name'],
                'slug' => $data['slug'],
                'price' => $data['price'],
                'description' => $data['description'] ?? null,
                'status' => $data['status'] ?? 'active'
            ]);

            // Handle thumbnail (replace if new uploaded)
            if ($thumbnail) {
                // Get current product data to get old thumbnail_id
                $currentProduct = $this->productRepository->findById($id);
                
                // Delete old thumbnail if exists
                if ($currentProduct && $currentProduct->thumbnail_id) {
                    $this->mediaService->deleteImage($currentProduct->thumbnail_id);
                }

                // Upload new thumbnail
                $thumbnailMedia = $this->mediaService->uploadImage(
                    $thumbnail,
                    'product',
                    $product->id,
                    true
                );
                
                // Update product with new thumbnail_id
                $this->productRepository->update($product->id, [
                    'thumbnail_id' => $thumbnailMedia->id
                ]);
            }

            // Handle multiple images (add new)
            if (!empty($images)) {
                foreach ($images as $image) {
                    $this->mediaService->uploadImage(
                        $image,
                        'product',
                        $product->id,
                        false
                    );
                }
            }

            // Update attributes
            if (isset($data['attributes'])) {
                $this->productRepository->deleteAttributes($product->id); // hapus lama
                $this->productRepository->syncAttributes($product->id, $data['attributes']);
            }

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}