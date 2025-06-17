<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Illuminate\Http\UploadedFile;

class SettingService
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getSettings()
    {
        return $this->settingRepository->getAllSettings();
    }

    public function updateSettings($data)
    {
        foreach ($data as $key => $value) {
            if ($value instanceof UploadedFile) {
                // Handle file uploads based on type
                switch ($key) {
                    case 'logo':
                    $path = $value->store('images/logo', 'public');
                    break;
                    
                    case 'favicon':
                    $path = $value->store('images/favicon', 'public');
                    break;
                    
                    case 'homepage_hero':
                    $mimeType = $value->getMimeType();
                    if (str_starts_with($mimeType, 'video/')) {
                        $path = $value->store('videos', 'public');
                    } else {
                        $path = $value->store('images/hero', 'public');
                    }
                    break;
                    
                    default:
                    $path = $value->store('images/contents', 'public');
                }

                if (app()->environment('production')) {
                    $value = 'https://app.bumirealty.id/public/storage/' . ltrim($path, '/');
                } else {
                    $value = '/' . $path;
                }
            }
            
            $this->settingRepository->updateSetting($key, $value);
        }
        return true;
    }
}