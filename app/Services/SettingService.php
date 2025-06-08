<?php

namespace App\Services;

use App\Repositories\SettingRepository;

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
}