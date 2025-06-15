<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ServiceService;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        return view('dashboard.layanan', [
            'services' => $this->serviceService->getAll('active'),
        ]);
    }

    public function create()
    {
        return view('dashboard.layanan-create');
    }

    public function edit($id)
    {
        $service = $this->serviceService->find($id);
        if (!$service) {
            abort(404);
        }
        return view('dashboard.layanan-edit', [
            'service' => $service
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'sort_order' => 'required|integer|min:1',
            'icon' => 'required|image|mimes:jpeg,png|max:1024',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('/images/contents', 'public');
            $validated['icon'] = '/' . $iconPath;
        }

        $this->serviceService->create($validated);

        return redirect()
            ->route('service.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'sort_order' => 'required|integer|min:1',
            'icon' => 'nullable|image|mimes:jpeg,png|max:1024',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('/images/contents', 'public');
            $validated['icon'] = '/' . $iconPath;
        } else {
            unset($validated['icon']);
        }

        $this->serviceService->update($id, $validated);

        return redirect()->route('service.index')->with('success', 'Layanan berhasil diupdate.');
    }
}
