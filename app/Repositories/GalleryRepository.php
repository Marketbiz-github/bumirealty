<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class GalleryRepository
{
    public function getAllGallery($status = 'active')
    {
        $query = DB::table('media_files')
            ->where('usage_type', 'gallery')
            ->orderBy('created_at', 'desc');
        if ($status) {
            $query->where('status', $status);
        }
        return $query->get();
    }
}