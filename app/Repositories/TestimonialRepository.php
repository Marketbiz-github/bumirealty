<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TestimonialRepository
{
    protected $table = 'testimonials';

    public function getAllTestimonials($status = null)
    {
        $query = DB::table($this->table)
            ->select([
                'id',
                'name',
                'message',
                'rating',
                'status',
                'created_at'
            ])
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function create($data)
    {
        return DB::table($this->table)->insert([
            'id' => $data['id'],
            'name' => $data['name'],
            'message' => $data['message'],
            'rating' => $data['rating'],
            'status' => $data['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function findById($id)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->first();
    }

    public function update($id, $data)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'message' => $data['message'],
                'rating' => $data['rating'],
                'status' => $data['status'],
                'updated_at' => now(),
            ]);
    }
}