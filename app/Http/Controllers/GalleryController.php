<?php

namespace App\Http\Controllers;

use App\Services\GalleryService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $galleryService;
    protected $settingService;
    protected $settings;

    public function __construct(
        GalleryService $galleryService,
        SettingService $settingService
    ) {
        $this->galleryService = $galleryService;
        $this->settingService = $settingService;
        $this->settings = $this->settingService->getSettings();
    }

    public function index()
    {
        return view('dashboard.gallery', [
            'settings' => $this->settings,
            'galleries' => $this->galleryService->getGallery(null),
        ]);
    }
    public function create()
    {
        return view('dashboard.gallery-create', [
            'settings' => $this->settings,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png|max:2048',
            ]);

            $gallery = $this->galleryService->store($validated, $request->file('image'));

            return redirect()
                ->route('gallery.index')
                ->with('success', 'Gallery image berhasil ditambahkan.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan gallery image. ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $gallery = $this->galleryService->findById($id);
        if (!$gallery) {
            return redirect()
                ->route('gallery.index')
                ->with('error', 'Gallery tidak ditemukan.');
        }

        return view('dashboard.gallery-edit', [
            'settings' => $this->settings,
            'gallery' => $gallery
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png|max:2048',
                'status' => 'required|in:active,inactive'
            ]);

            $gallery = $this->galleryService->update($id, $validated, $request->file('image'));

            return redirect()
                ->route('gallery.index')
                ->with('success', 'Gallery berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui gallery. ' . $e->getMessage());
        }
    }
}