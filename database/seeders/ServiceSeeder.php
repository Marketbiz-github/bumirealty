<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Lahan Kavling',
                'description' => 'Menyediakan pilihan lahan kavling strategis dan siap bangun, cocok untuk investasi maupun hunian pribadi',
                'icon' => '/images/contents/management.png',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'title' => 'Agency Properti',
                'description' => 'Layanan profesional dalam jual beli dan sewa properti, membantu Anda menemukan properti impian.',
                'icon' => '/images/contents/property-insurance.png',
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'title' => 'Kontraktor Rumah',
                'description' => 'Jasa pembangunan rumah, dengan kualitas bangunan terbaik dan waktu pengerjaan sesuai jadwal.',
                'icon' => '/images/contents/architect.png',
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'title' => 'Desain Interior',
                'description' => 'Menyediakan layanan desain interior kreatif dan fungsional, menjadikan ruang Anda lebih nyaman.',
                'icon' => '/images/contents/shelf.png',
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'title' => 'Kontraktor Jalan',
                'description' => 'Spesialis pembangunan dan perbaikan infrastruktur jalan dengan standar kualitas tinggi.',
                'icon' => '/images/contents/road-sign.png',
                'status' => 'active',
                'sort_order' => 5,
            ],
        ];

        $now = Carbon::now();
        foreach ($services as $i => $service) {
            DB::table('services')->insert([
                'id' => (string) Str::uuid(),
                'title' => $service['title'],
                'slug' => Str::slug($service['title']),
                'description' => $service['description'],
                'icon' => $service['icon'],
                'status' => $service['status'] ?? 'active',
                'sort_order' => $service['sort_order'] ?? $i,
                'created_at' => $now->copy()->addMinutes($i),
                'updated_at' => $now->copy()->addMinutes($i),
            ]);
        }
    }
}
