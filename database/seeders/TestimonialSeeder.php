<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Putri Andini',
                'message' => 'Pelayanan sangat profesional dan tanah yang saya beli memiliki lokasi strategis dengan harga yang terjangkau. Sangat recommended untuk investasi jangka panjang.',
                'rating' => 5,
                'status' => 'active',
            ],
            [
                'name' => 'Made Arya',
                'message' => 'Awalnya ragu, tapi setelah konsultasi saya yakin. Terima kasih BumiRealty!',
                'rating' => 4,
                'status' => 'active',
            ],
            [
                'name' => 'Wayan Surya',
                'message' => 'Lokasi kavling strategis, harga masuk akal, dokumen lengkap. Sangat puas!',
                'rating' => 4,
                'status' => 'active',
            ],
            [
                'name' => 'Agus Saputra',
                'message' => 'Layanan pengurusan sertifikatnya sangat membantu dan cepat.',
                'rating' => 4,
                'status' => 'inactive', 
            ],
            [
                'name' => 'Pan Jaya',
                'message' => 'Prosesnya cepat dan mudah, team sangat membantu menjelaskan semua hal yang diperlukan. Saya sangat puas dengan pelayanan yang diberikan.',
                'rating' => 5,
                'status' => 'active',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            DB::table('testimonials')->insert([
                'id'         => (string) Str::uuid(),
                'name'       => $testimonial['name'],
                'message'    => $testimonial['message'],
                'rating'     => $testimonial['rating'],
                'status'     => $testimonial['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
