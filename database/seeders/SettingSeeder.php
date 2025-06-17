<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Branding
            ['key' => 'site_title',         'value' => 'BumiRealty.id'],
            ['key' => 'site_tagline',       'value' => 'Solusi Properti Impian Anda'],
            ['key' => 'logo',               'value' => '/images/contents/bumirealty.png'],
            ['key' => 'favicon',            'value' => '/images/contents/favicon.ico'],

            // Homepage content
            ['key' => 'homepage_h1',        'value' => 'Website bumirealty.id'],
            ['key' => 'homepage_subtitle',  'value' => 'Kavling premium di lokasi strategis'],
            ['key' => 'homepage_hero',      'value' => '/images/contents/vid.mp4'],

            // kavling content
            ['key' => 'kavling_h1',        'value' => 'Kavling Berjalan'],
            ['key' => 'kavling_subtitle',  'value' => 'Jangan lewatkan kesempatan emas untuk memiliki kavling strategis di lokasi premium yang menjanjikan untuk kepentingan investasi yang menguntungkan.'],
            ['key' => 'kavling_hero',      'value' => '/images/contents/bg.png'],

            // layanan content
            ['key' => 'layanan_h1',        'value' => 'Produk Layanan'],
            ['key' => 'layanan_subtitle',  'value' => 'Kami hadir untuk memberikan solusi terbaik bagi kebutuhan Anda. Dengan pengalaman dan tim yang berpengalaman, layanan kami dikembangkan untuk memberikan hasil maksimal.'],
            ['key' => 'layanan_hero',      'value' => '/images/contents/bg.png'],

            // testimoni content
            ['key' => 'testimoni_h1',        'value' => 'Testimonial Konsumen'],
            ['key' => 'testimoni_subtitle',  'value' => 'Apa kata mereka yang telah menggunakan jasa BumiRealty.id'],
            ['key' => 'testimoni_hero',      'value' => '/images/contents/bg.png'],

            // portofolio content
            ['key' => 'portofolio_h1',        'value' => 'Portofolio project'],
            ['key' => 'portofolio_subtitle',  'value' => 'Kumpulan hasil kerja terbaik kami dalam berbagai bidang, setiap proyek mencerminkan komitmen kami terhadap kualitas, inovasi, serta kepuasan klien.'],
            ['key' => 'portofolio_hero',      'value' => '/images/contents/bg.png'],

            // galeri content
            ['key' => 'galeri_h1',        'value' => 'Galeri Project'],
            ['key' => 'galeri_subtitle',  'value' => 'Lihat berbagai proyek yang telah kami kerjakan, mulai dari pembangunan infrastruktur hingga pengembangan properti. Setiap proyek mencerminkan komitmen kami terhadap kualitas dan inovasi.'],
            ['key' => 'galeri_hero',      'value' => '/images/contents/bg.png'],

            // Footer
            ['key' => 'footer_text',        'value' => '© ' . date('Y') . ' BumiRealty. All rights reserved.'],

            // Contact
            ['key' => 'alamat',             'value' => 'Jl. Gatot Subroto No.45, Denpasar Selatan'],
            ['key' => 'email',              'value' => 'info@bumirealty.id'],
            ['key' => 'whatsapp',           'value' => '6281234567890'],

            // Social Media
            ['key' => 'instagram',          'value' => 'https://instagram.com/bumirealty.id'],
            ['key' => 'facebook',           'value' => 'https://facebook.com/bumirealty.id'],

            // Meta SEO
            ['key' => 'meta_title',         'value' => 'BumiRealty - Kavling & Properti Terpercaya di Bali'],
            ['key' => 'meta_description',   'value' => 'Temukan kavling strategis dan layanan properti terpercaya di Bali bersama BumiRealty.'],
            ['key' => 'meta_keywords',      'value' => 'kavling, properti bali, jual tanah, beli kavling'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'id'         => (string) Str::uuid(),
                'key'        => $setting['key'],
                'value'      => $setting['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
