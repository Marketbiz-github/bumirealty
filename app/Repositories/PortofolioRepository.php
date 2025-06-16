<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function create($data)
    {
        $data['id'] = Str::uuid();
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('portofolios')->insert($data);
        return DB::table('portofolios')->where('id', $data['id'])->first();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = now();
        
        DB::table('portofolios')
            ->where('id', $id)
            ->update($data);

        return DB::table('portofolios')->where('id', $id)->first();
    }
    
    public function findById($id)
    {
        return DB::table('portofolios')->where('id', $id)->first();
    }

    public function getTotalCount($status = 'active')
    {
        $query = DB::table('portofolios');
        
        if ($status) {
            $query->where('status', $status);
        }

        return $query->count();
    }
}