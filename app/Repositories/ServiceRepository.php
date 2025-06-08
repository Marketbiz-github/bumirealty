<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ServiceRepository
{
    public function getAllServices($status = 'active')
    {
        $query = DB::table('services')->orderBy('sort_order', 'asc');
        if ($status == 'active') {
            $query->where('status', 'active');
        }
        return $query->get();
    }
}