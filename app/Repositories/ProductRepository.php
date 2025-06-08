<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function getAllProducts($sortBy = 'created_at', $direction = 'desc', $status = 'active')
    {
        // Ambil produk beserta kategori
        $products = DB::table('products')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.*',
                'product_categories.name as category_name'
            )
            ->when($status, function ($query) use ($status) {
                $query->where('products.status', $status);
            })
            ->orderBy("products.$sortBy", $direction)
            ->get();

        // Ambil semua media aktif yang terkait produk
        $media = DB::table('media_files')
            ->where('usage_type', 'product')
            ->where('status', 'active')
            ->get()
            ->groupBy('usage_id');

        // Ambil semua attribute value yang terkait produk
        $attributes = DB::table('product_attribute_values')
            ->leftJoin('product_attributes', 'product_attribute_values.attribute_id', '=', 'product_attributes.id')
            ->select(
                'product_attribute_values.*',
                'product_attributes.name as attribute_name',
                'product_attributes.slug as attribute_slug',
                'product_attributes.type as attribute_type'
            )
            ->get()
            ->groupBy('product_id');

        // Gabungkan data ke masing-masing produk
        foreach ($products as $product) {
            $product->media = $media[$product->id] ?? [];
            $product->attributes = $attributes[$product->id] ?? [];

            // Ambil thumbnail_url dari media yang is_main = true
            $mainMedia = collect($product->media)->firstWhere('is_main', true);
            $product->thumbnail_url = $mainMedia->url ?? null;
        }

        return $products;
    }
}