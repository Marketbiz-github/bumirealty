<?php

namespace App\Http\Controllers;

use App\Services\TestimonialService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    protected $testimonialService;
    protected $settingService;
    protected $settings;

    public function __construct(
        TestimonialService $testimonialService,
        SettingService $settingService
    ) {
        $this->testimonialService = $testimonialService;
        $this->settingService = $settingService;
        $this->settings = $this->settingService->getSettings();
    }

    public function index()
    {
        return view('dashboard.testimonial', [
            'settings' => $this->settings,
            'testimonials' => $this->testimonialService->getTestimonials(null),
        ]);
    }

    public function create()
    {
        return view('dashboard.testimonial-create', [
            'settings' => $this->settings
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'nullable',
            'rating' => 'required|integer|between:1,5',
        ]);

        $validated['status'] = 'active';

        $this->testimonialService->create($validated);

        return redirect()
            ->route('testimonial.index')
            ->with('success', 'Testimonial created successfully');
    }

    public function edit($id)
    {
        $testimonial = $this->testimonialService->find($id);
        
        return view('dashboard.testimonial-edit', [
            'settings' => $this->settings,
            'testimonial' => $testimonial
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'nullable',
            'rating' => 'required|integer|between:1,5',
            'status' => 'required|in:active,inactive',
        ]);

        $this->testimonialService->update($id, $validated);

        return redirect()
            ->route('testimonial.index')
            ->with('success', 'Testimonial updated successfully');
    }
}