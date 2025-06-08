<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TestimonialRepository
{
    public function getAllTestimonials($status = 'active')
    {
        $query = DB::table('testimonials')->orderBy('created_at', 'desc');
        if ($status == 'active') {
            $query->where('status', 'active');
        }
        return $query->get();
    }
}