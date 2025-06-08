<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class SettingRepository
{
    public function getAllSettings()
    {
        return DB::table('settings')->pluck('value', 'key');
    }
}