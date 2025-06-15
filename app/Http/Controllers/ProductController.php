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
            'products' => $this->productService->getAllProducts('created_at', 'desc', 'active'),
            'settings' => $this->settings,
        ]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.kavling-create', [
            'settings' => $this->settings,
        ]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('products.show', compact('id'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('products.edit', compact('id'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation and update logic here
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete logic here
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
