<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\SettingService;

class DashboardController extends Controller
{
    protected $dashboardService;
    protected $settingService;
    protected $settings;

    public function __construct(
        DashboardService $dashboardService,
        SettingService $settingService
    ) {
        $this->dashboardService = $dashboardService;
        $this->settingService = $settingService;
        $this->settings = $this->settingService->getSettings();
    }

    public function index()
    {
        $stats = $this->dashboardService->getDashboardStats();

        return view('dashboard.dashboard', [
            'settings' => $this->settings,
            'stats' => $stats
        ]);
    }
}