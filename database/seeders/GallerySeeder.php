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
            ['status' => 'active'],
            ['status' => 'active'],
            ['status' => 'active'],
            ['status' => 'active'],
            ['status' => 'active'],
            ['status' => 'inactive'],
            ['status' => 'active'],
        ];

        foreach ($galleryItems as $item) {
            $imgNum = rand(1, 10); // Angka sesuai jumlah gambar dummy kamu
            $imagePath = "images/products/dummy ($imgNum).jpg";
            $imageUrl = asset($imagePath);

            DB::table('media_files')->insert([
                'id'          => (string) Str::uuid(),
                'url'         => $imageUrl,
                'usage_type'  => 'gallery',
                'status'      => $item['status'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
