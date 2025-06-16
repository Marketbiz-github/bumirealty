<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class GalleryRepository
{
    protected $table = 'media_files';

    public function getAllGallery($status = null)
    {
        $query = DB::table($this->table)
            ->where('usage_type', 'gallery')
            ->orderBy('created_at', 'desc');

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function update($id, $data)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->update(array_merge($data, [
                'updated_at' => now()
            ]));
    }

    public function delete($id)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->update([
                'status' => 'inactive',
                'updated_at' => now()
            ]);
    }
    
    public function findById($id)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->first();
    }

    public function getTotalCount($status = 'active')
    {
        $query = DB::table($this->table)
            ->where('usage_type', 'gallery');
        
        if ($status) {
            $query->where('status', $status);
        }

        return $query->count();
    }
}