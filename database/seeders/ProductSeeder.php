<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = Str::uuid();

        // 🔹 Product Category: Kavling
        DB::table('product_categories')->insert([
            'id' => $categoryId,
            'name' => 'Kavling',
            'slug' => 'kavling',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 🔹 Product Attributes
        $attrLuas = Str::uuid();
        $attrLokasi = Str::uuid();
        $attrGmaps = Str::uuid();

        DB::table('product_attributes')->insert([
            [
                'id' => $attrLuas,
                'name' => 'Luas Tanah',
                'slug' => 'luas-tanah',
                'type' => 'text',
                'category_id' => $categoryId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => $attrLokasi,
                'name' => 'Lokasi',
                'slug' => 'lokasi',
                'type' => 'text',
                'category_id' => $categoryId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => $attrGmaps,
                'name' => 'Google Maps URL',
                'slug' => 'gmaps-url',
                'type' => 'text',
                'category_id' => $categoryId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 🔹 Products
        $products = [
            [
                'name' => 'Bumi Mesari Residence Blumbungan',
                'slug' => 'bumi-mesari-residence-blumbungan',
                'lokasi' => 'Blumbungan',
                'luas' => '90 m²',
                'gmaps' => 'https://maps.google.com/?q=Blumbungan',
                'price' => 300000000,
            ],
            [
                'name' => 'Bumi Mesari Residence Batual',
                'slug' => 'bumi-mesari-residence-batual',
                'lokasi' => 'Batual',
                'luas' => '100 m²',
                'gmaps' => 'https://maps.google.com/?q=Batual',
                'price' => 320000000,
            ],
            [
                'name' => 'Bumi Mesari Residence Antasura',
                'slug' => 'bumi-mesari-residence-antasura',
                'lokasi' => 'Antasura',
                'luas' => '120 are',
                'gmaps' => 'https://maps.google.com/?q=Antasura',
                'price' => 350000000,
            ],
        ];

        foreach ($products as $p) {
            $productId = Str::uuid();

            // Pilih gambar random tanpa duplikat untuk setiap produk
            $imageIndexes = collect(range(1, 10))->shuffle()->take(3)->values();

            $mediaIds = [];
            foreach ($imageIndexes as $idx => $imgNum) {
                $mediaId = Str::uuid();
                $mediaIds[] = $mediaId;

                // Gunakan asset() untuk generate url gambar
                $imagePath = "images/products/dummy ($imgNum).jpg";
                $imageUrl = asset($imagePath);

                DB::table('media_files')->insert([
                    'id' => $mediaId,
                    'url' => $imageUrl,
                    'usage_type' => 'product',
                    'usage_id' => $productId,
                    'is_main' => $idx === 0, // gambar pertama jadi thumbnail
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $thumbnailId = $mediaIds[0];

            DB::table('products')->insert([
                'id' => $productId,
                'category_id' => $categoryId,
                'name' => $p['name'],
                'slug' => $p['slug'],
                'price' => $p['price'],
                'description' => "{$p['name']} adalah kavling properti di {$p['lokasi']}.",
                'thumbnail_id' => $thumbnailId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attribute Values
            DB::table('product_attribute_values')->insert([
                [
                    'id' => Str::uuid(),
                    'product_id' => $productId,
                    'attribute_id' => $attrLuas,
                    'value' => $p['luas'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => Str::uuid(),
                    'product_id' => $productId,
                    'attribute_id' => $attrLokasi,
                    'value' => $p['lokasi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => Str::uuid(),
                    'product_id' => $productId,
                    'attribute_id' => $attrGmaps,
                    'value' => $p['gmaps'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
