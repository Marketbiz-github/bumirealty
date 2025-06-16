<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function edit()
    {
        return view('dashboard.settings', [
            'settings' => $this->settingService->getSettings()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Branding
            'site_title' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'logo' => 'sometimes|nullable|image|mimes:jpeg,png|max:1024',
            'favicon' => 'sometimes|nullable|mimes:ico,png|max:100',
            
            // Homepage
            'homepage_h1' => 'required|string|max:255',
            'homepage_subtitle' => 'required|string|max:255',
            'homepage_hero' => 'sometimes|nullable|mimes:mp4,jpeg,png,jpg|max:51200', // 50MB max
            
            // Contact
            'email' => 'required|email',
            'whatsapp' => 'required|string',
            'alamat' => 'nullable|string',
            
            // Social Media
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            
            // SEO
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            
            // Footer
            'footer_text' => 'required|string|max:255',
        ]);

        // Only update files if they are provided
        $data = $validated;
        if (!$request->hasFile('logo')) {
            unset($data['logo']);
        }
        if (!$request->hasFile('favicon')) {
            unset($data['favicon']);
        }
        if (!$request->hasFile('homepage_hero')) {
            unset($data['homepage_hero']);
        }

        $this->settingService->updateSettings($data);

        return redirect()
            ->route('settings.edit')
            ->with('success', 'Settings updated successfully');
    }
}