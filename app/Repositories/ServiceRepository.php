<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ServiceRepository
{
    public function getAllServices($status = null)
    {
        $query = DB::table('services')->orderBy('sort_order', 'asc');
        if ($status === 'active') {
            $query->where('status', 'active');
        }
        return $query->get();
    }

    public function findById($id)
    {
        return DB::table('services')->where('id', $id)->first();
    }

    public function update($id, $data)
    {
        return DB::table('services')->where('id', $id)->update($data);
    }
    public function create($data)
    {
        return DB::table('services')->insert($data);
    }
}