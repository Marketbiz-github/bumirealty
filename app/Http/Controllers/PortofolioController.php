<?php

namespace App\Http\Controllers;

use App\Services\PortofolioService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class PortofolioController extends Controller
{
    protected $portofolioService;
    protected $settingService;
    protected $settings;

    public function __construct(
        PortofolioService $portofolioService,
        SettingService $settingService
    ) {
        $this->portofolioService = $portofolioService;
        $this->settingService = $settingService;
        $this->settings = $this->settingService->getSettings();
    }

    public function index()
    {
        return view('dashboard.portofolio', [
            'settings' => $this->settings,
            'portofolios' => $this->portofolioService->getPortofolios(null),
        ]);
    }
    public function create()
    {
        return view('dashboard.portofolio-create', [
            'settings' => $this->settings,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png|max:1024',
                'images' => 'required|array|min:1|max:5',
                'images.*' => 'image|mimes:jpeg,png|max:2048',
                'image_order' => 'required|array'
            ]);

            // Get the ordered images array
            $orderedImages = [];
            foreach ($request->file('images') as $image) {
                $orderedImages[] = $image;
            }

            $portofolio = $this->portofolioService->store(
                $validated,
                $request->file('thumbnail'),
                $orderedImages
            );

            return redirect()
                ->route('portofolio.index')
                ->with('success', 'Portofolio berhasil ditambahkan.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan portofolio. ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $portofolio = $this->portofolioService->findById($id);
        if (!$portofolio) {
            return redirect()->route('portofolio.index')->with('error', 'Portofolio tidak ditemukan.');
        }

        return view('dashboard.portofolio-edit', [
            'settings' => $this->settings,
            'portofolio' => $portofolio,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'thumbnail' => 'nullable|image|mimes:jpeg,png|max:1024',
                'images' => 'nullable|array|max:5',
                'images.*' => 'image|mimes:jpeg,png|max:2048',
                'status' => 'required|in:active,inactive',
                'deleted_images' => 'nullable|array',
                'deleted_images.*' => 'string'
            ]);

            $portofolio = $this->portofolioService->update(
                $id,
                $validated,
                $request->file('thumbnail'),
                $request->file('images') ?? [],
                $request->input('deleted_images', [])
            );

            return redirect()
                ->route('portofolio.index')
                ->with('success', 'Portofolio berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui portofolio. ' . $e->getMessage());
        }
    }
}