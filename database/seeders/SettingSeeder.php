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

            // Open Graph (OG) Meta Tags
            ['key' => 'og_image',           'value' => '/images/contents/bumirealty.png'],
            ['key' => 'og_title',           'value' => 'BumiRealty - Properti Impian Anda'],
            ['key' => 'og_description',     'value' => 'Jual beli kavling di lokasi strategis Bali dengan proses aman dan terpercaya.'],
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
