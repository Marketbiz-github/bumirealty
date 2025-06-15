<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\SettingService;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productService;
    protected $settingService;

    protected $settings;

    public function __construct(
        ProductService $productService,
        SettingService $settingService,
    ) {
        $this->productService = $productService;
        $this->settingService = $settingService;

        // Inisialisasi data utama
        $this->settings = $this->settingService->getSettings();
    }
    public function index()
    {
        return view('dashboard.kavling', [
            'products' => $this->productService->getAllProducts('updated_at', 'desc', null),
            'settings' => $this->settings,
        ]);
    }

    public function create()
    {
        return view('dashboard.kavling-create', [
            'settings' => $this->settings,
        ]);
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable',
                'thumbnail' => 'required|image|mimes:jpeg,png|max:1024',
                'images' => 'required|array|min:1|max:5',
                'images.*' => 'image|mimes:jpeg,png|max:2048',
                'attributes.luas-tanah' => 'required',
                'attributes.lokasi' => 'required',
                'attributes.gmaps-url' => 'nullable|url',
            ]);

            Log::info('Product data', $validated);

            $product = $this->productService->store(
                $validated,
                $request->file('thumbnail'),
                $request->file('images')
            );

            Log::info('Product created successfully', ['product_id' => $product->id]);

            return redirect()
                ->route('products.index')
                ->with('success', 'Kavling berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Product validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e;

        } catch (\Exception $e) {
            Log::error('Failed to create product', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan kavling. ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = $this->productService->findById($id);
        if (!$product) abort(404);

        return view('dashboard.kavling-edit', [
            'product' => $product,
            'settings' => $this->settings,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:active,inactive',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable',
                'thumbnail' => 'nullable|image|mimes:jpeg,png|max:1024',
                'images' => 'nullable|array|max:5',
                'images.*' => 'image|mimes:jpeg,png|max:2048',
                'attributes.luas-tanah' => 'required',
                'attributes.lokasi' => 'required',
                'attributes.gmaps-url' => 'nullable|url',
            ]);

            // dd($request->all(), $validated, $request->file('thumbnail'), $request->file('images'), $request->input('remove_images', []));
            $images = $request->file('images');

            $this->productService->update(
                $id,
                $validated,
                $request->file('thumbnail'),
                $images,
                $request->input('remove_images', []) // ambil array id gambar yang dihapus
            );

            return redirect()
                ->route('products.index')
                ->with('success', 'Kavling berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal update kavling. ' . $e->getMessage());
        }
    }

}
