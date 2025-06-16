<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleryItems = [
            ['name' => 'Gallery Image 1', 'status' => 'active'],
            ['name' => 'Gallery Image 2', 'status' => 'active'],
            ['name' => 'Gallery Image 3', 'status' => 'active'],
            ['name' => 'Gallery Image 4', 'status' => 'active'],
            ['name' => 'Gallery Image 5', 'status' => 'active'],
            ['name' => 'Gallery Image 6', 'status' => 'inactive'],
            ['name' => 'Gallery Image 7', 'status' => 'active'],
        ];

        foreach ($galleryItems as $item) {
            $imgNum = rand(1, 10); // Angka sesuai jumlah gambar dummy kamu
            $imagePath = "images/products/dummy ($imgNum).jpg";
            $imageUrl = asset($imagePath);

            DB::table('media_files')->insert([
                'id'          => (string) Str::uuid(),
                'name'        => $item['name'],
                'url'         => $imageUrl,
                'usage_type'  => 'gallery',
                'status'      => $item['status'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
