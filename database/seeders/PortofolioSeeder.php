<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PortofolioSeeder extends Seeder
{
    public function run(): void
    {
        $portfolios = [
            [
                'name' => 'Kavling Jimbaran Asri',
                'description' => 'Proyek pengembangan kavling eksklusif di kawasan premium Jimbaran, Bali. Kavling ini menawarkan lingkungan yang tenang dan asri, dekat dengan berbagai fasilitas umum seperti sekolah, rumah sakit, dan pusat perbelanjaan. Lokasi strategis hanya beberapa menit dari pantai Jimbaran, menjadikan investasi properti ini sangat menjanjikan baik untuk hunian maupun bisnis.',
                'status' => 'active',
            ],
            [
                'name' => 'Perumahan Bukit Hijau',
                'description' => 'Perumahan hijau dengan konsep eco-living di Tabanan. Setiap unit dirancang dengan memperhatikan aspek ramah lingkungan, seperti penggunaan material bangunan berkelanjutan dan sistem pengelolaan air hujan. Dilengkapi dengan taman luas, area bermain anak, serta akses mudah ke jalur transportasi utama, menjadikan perumahan ini pilihan ideal bagi keluarga modern yang peduli lingkungan.',
                'status' => 'active',
            ],
            [
                'name' => 'Kavling Seririt View Laut',
                'description' => 'Kavling dengan pemandangan laut lepas di Buleleng. Lokasi berada di dataran tinggi sehingga menawarkan panorama matahari terbenam yang indah setiap hari. Cocok untuk pembangunan vila pribadi atau investasi properti wisata, dengan akses mudah ke destinasi wisata populer di Bali Utara dan suasana yang masih alami serta tenang.',
                'status' => 'inactive',
            ],
            [
                'name' => 'Villa Ubud Harmony',
                'description' => 'Villa eksklusif di Ubud dengan pemandangan sawah dan sungai. Didesain untuk kenyamanan dan privasi maksimal, cocok untuk investasi atau hunian keluarga.',
                'status' => 'active',
            ],
            [
                'name' => 'Ruko Sunset Road',
                'description' => 'Kompleks ruko strategis di kawasan Sunset Road, Denpasar. Cocok untuk bisnis retail, kantor, atau investasi properti komersial.',
                'status' => 'active',
            ],
            [
                'name' => 'Cluster Sanur Beachside',
                'description' => 'Cluster hunian modern dekat pantai Sanur, menawarkan akses mudah ke fasilitas wisata dan pusat kota Denpasar.',
                'status' => 'active',
            ],
            [
                'name' => 'Kavling Tabanan Riverside',
                'description' => 'Kavling dengan view sungai di Tabanan, cocok untuk villa atau rumah peristirahatan dengan suasana alam.',
                'status' => 'active',
            ],
            [
                'name' => 'Apartemen Kuta Central',
                'description' => 'Apartemen modern di pusat Kuta, dekat dengan pusat perbelanjaan dan hiburan. Fasilitas lengkap dan keamanan 24 jam.',
                'status' => 'active',
            ],
            [
                'name' => 'Perumahan Canggu Green',
                'description' => 'Perumahan dengan konsep green living di Canggu, dekat dengan pantai dan area wisata populer.',
                'status' => 'active',
            ],
            [
                'name' => 'Kavling Bedugul Highland',
                'description' => 'Kavling di dataran tinggi Bedugul, menawarkan udara sejuk dan pemandangan pegunungan yang indah.',
                'status' => 'active',
            ],
        ];

        foreach ($portfolios as $portfolio) {
            $portfolioId = (string) Str::uuid();

            // Pilih 3 gambar random tanpa duplikat untuk setiap portofolio
            $imageIndexes = collect(range(1, 10))->shuffle()->take(3)->values();

            $mediaIds = [];
            foreach ($imageIndexes as $idx => $imgNum) {
                $mediaId = (string) Str::uuid();
                $mediaIds[] = $mediaId;

                $imagePath = "images/products/dummy ($imgNum).jpg";
                $imageUrl = asset($imagePath);

                DB::table('media_files')->insert([
                    'id' => $mediaId,
                    'url' => $imageUrl,
                    'usage_type' => 'portofolio',
                    'usage_id' => $portfolioId,
                    'is_main' => $idx === 0, // gambar pertama jadi thumbnail
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $thumbnailId = $mediaIds[0];

            DB::table('portofolios')->insert([
                'id'           => $portfolioId,
                'name'         => $portfolio['name'],
                'slug'         => Str::slug($portfolio['name']),
                'description'  => $portfolio['description'],
                'thumbnail_id' => $thumbnailId,
                'status'       => $portfolio['status'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
