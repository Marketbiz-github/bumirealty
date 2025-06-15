<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductRepository
{
    protected $table = 'products';
    protected $attributeTable = 'product_attribute_values';

    public function create(array $data)
    {
        // Get kavling category id
        $kavlingCategory = DB::table('product_categories')
            ->where('slug', 'kavling')
            ->where('status', 'active')
            ->first();

        if (!$kavlingCategory) {
            throw new \Exception('Kavling category not found');
        }

        $data['id'] = Str::uuid();
        $data['category_id'] = $kavlingCategory->id;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table($this->table)->insert($data);
        return DB::table($this->table)->where('id', $data['id'])->first();
    }

    public function update($id, array $data)
    {
        $data['updated_at'] = now();
        
        DB::table($this->table)
            ->where('id', $id)
            ->update($data);

        return DB::table($this->table)->where('id', $id)->first();
    }

    public function syncAttributes($productId, array $attributes)
    {
        // Get all attributes for kavling category
        $kavlingAttributes = DB::table('product_attributes')
            ->join('product_categories', 'product_attributes.category_id', '=', 'product_categories.id')
            ->where('product_categories.slug', 'kavling')
            ->where('product_attributes.status', 'active')
            ->pluck('product_attributes.id', 'product_attributes.slug')
            ->toArray();

        foreach ($attributes as $key => $value) {
            // Get attribute ID based on slug
            $attributeId = $kavlingAttributes[$key] ?? null;
            
            if (!$attributeId) {
                throw new \Exception("Attribute with slug '{$key}' not found");
            }

            DB::table($this->attributeTable)->insert([
                'id' => Str::uuid(),
                'product_id' => $productId,
                'attribute_id' => $attributeId,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

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