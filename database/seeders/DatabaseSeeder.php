<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SuperAdminSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(PortofolioSeeder::class);
        $this->call(GallerySeeder::class);
    }
}
