<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PortofolioRepository
{
    public function getAllPortofolios($status = 'active')
    {
        $query = DB::table('portofolios')->orderBy('created_at', 'desc');
        if ($status) {
            $query->where('status', $status);
        }
        $portofolios = $query->get();

        // Ambil semua media aktif yang terkait portofolio
        $media = DB::table('media_files')
            ->where('usage_type', 'portofolio')
            ->where('status', 'active')
            ->get()
            ->groupBy('usage_id');

        // Gabungkan data ke masing-masing portofolio
        foreach ($portofolios as $portofolio) {
            $portofolio->images = $media[$portofolio->id] ?? [];

            // Ambil thumbnail_url dari media yang is_main = true
            $mainMedia = collect($portofolio->images)->firstWhere('is_main', true);
            $portofolio->thumbnail_url = $mainMedia->url ?? null;
        }

        return $portofolios;
    }
}