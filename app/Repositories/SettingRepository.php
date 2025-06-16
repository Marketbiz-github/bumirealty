<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class SettingRepository
{
    protected $table = 'settings';

    public function getAllSettings()
    {
        return DB::table($this->table)
            ->orderBy('key')
            ->pluck('value', 'key')
            ->toArray();
    }

    public function updateSetting($key, $value)
    {
        return DB::table($this->table)
            ->updateOrInsert(
                ['key' => $key],
                [
                    'value' => $value,
                    'updated_at' => now()
                ]
            );
    }
}