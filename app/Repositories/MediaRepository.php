<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MediaRepository
{
    protected $table = 'media_files';

    public function create(array $data)
    {
        try {
            $id = Str::uuid();
            
            // Log data before insert
            Log::info('Attempting to insert media file', [
                'data' => array_merge(['id' => $id], $data)
            ]);

            $inserted = DB::table($this->table)->insert(array_merge(
                ['id' => $id],
                $data,
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ));

            if (!$inserted) {
                throw new \Exception('Failed to insert media file record');
            }

            // Get the inserted record
            $media = DB::table($this->table)->where('id', $id)->first();

            if (!$media) {
                throw new \Exception('Media file record not found after insert');
            }

            Log::info('Media file record created successfully', ['media_id' => $id]);

            return $media;
        } catch (\Exception $e) {
            Log::error('Failed to create media file record', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    public function getByUsageId($usageId, $type = 'product')
    {
        return DB::table($this->table)
            ->where('usage_id', $usageId)
            ->where('usage_type', $type)
            ->where('status', 'active')
            ->get();
    }

    public function delete($id)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->update(['status' => 'deleted', 'updated_at' => now()]);
    }
}