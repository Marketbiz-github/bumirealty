@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="">
    <x-breadcrumb :items="[['label' => 'Settings']]" />

    <div class="mt-8">
        <form id="settings-form" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Branding Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Branding</h2>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="site_title" value="Site Title *" />
                        <x-text-input id="site_title" name="site_title" type="text" class="mt-1 block w-full"
                            :value="old('site_title', $settings['site_title'] ?? '')" required />
                        <x-input-error :messages="$errors->get('site_title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="site_tagline" value="Tagline" />
                        <x-text-input id="site_tagline" name="site_tagline" type="text" class="mt-1 block w-full"
                            :value="old('site_tagline', $settings['site_tagline'] ?? '')" />
                        <x-input-error :messages="$errors->get('site_tagline')" class="mt-2" />
                    </div>
                </div>

                <!-- Branding Images -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Logo Upload -->
                    <div class="space-y-2">
                        <x-input-label for="logo" value="Logo *" />
                        <div class="space-y-4">
                            <div class="flex items-center justify-center w-full">
                                <label for="logo-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload Logo</span></p>
                                        <p class="text-xs text-gray-500">PNG, JPG up to 1MB</p>
                                    </div>
                                </label>
                                <input id="logo-upload" name="logo" type="file" accept="image/png, image/jpeg"
                                    style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                    aria-label="Upload logo image" />
                            </div>
                            <div id="logo-preview" class="{{ isset($settings['logo']) ? '' : 'hidden' }} w-32 h-32">
                                <img src="{{ isset($settings['logo']) ? asset($settings['logo']) : '' }}" 
                                    class="w-full h-full object-contain rounded-lg border border-gray-200" />
                            </div>
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Favicon Upload -->
                    <div class="space-y-2">
                        <x-input-label for="favicon" value="Favicon *" />
                        <div class="space-y-4">
                            <div class="flex items-center justify-center w-full">
                                <label for="favicon-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload Favicon</span></p>
                                        <p class="text-xs text-gray-500">ICO, PNG up to 100KB</p>
                                    </div>
                                </label>
                                <input id="favicon-upload" name="favicon" type="file" accept=".ico,image/x-icon,image/png"
                                    style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                    aria-label="Upload favicon" />
                            </div>
                            <div id="favicon-preview" class="{{ isset($settings['favicon']) ? '' : 'hidden' }} w-16 h-16">
                                <img src="{{ isset($settings['favicon']) ? asset($settings['favicon']) : '' }}" 
                                    class="w-full h-full object-contain rounded-lg border border-gray-200" />
                            </div>
                            <x-input-error :messages="$errors->get('favicon')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Homepage Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Homepage</h2>
                
                <div>
                    <x-input-label for="homepage_h1" value="H1 Title *" />
                    <x-text-input id="homepage_h1" name="homepage_h1" type="text" class="mt-1 block w-full"
                        :value="old('homepage_h1', $settings['homepage_h1'] ?? '')" required />
                    <x-input-error :messages="$errors->get('homepage_h1')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="homepage_subtitle" value="Subtitle *" />
                    <textarea id="homepage_subtitle" name="homepage_subtitle" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('homepage_subtitle', $settings['homepage_subtitle'] ?? '') }}
                    </textarea>
                    <x-input-error :messages="$errors->get('homepage_subtitle')" class="mt-2" />
                </div>

                <!-- Homepage Hero Media -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="homepage_hero" value="Hero (Video/Image) *" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="hero-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload Hero Media *</span></p>
                                    <p class="text-xs text-gray-500">MP4, PNG, JPG up to 50MB</p>
                                </div>
                            </label>
                            <input id="hero-upload" name="homepage_hero" type="file" 
                                accept="video/mp4,image/jpeg,image/png"
                                style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                aria-label="Upload hero media" />
                        </div>

                        @if(isset($settings['homepage_hero']))
                            <div id="hero-preview" class="text-center">
                                @php
                                    $extension = pathinfo($settings['homepage_hero'], PATHINFO_EXTENSION);
                                    $isVideo = in_array(strtolower($extension), ['mp4']);
                                @endphp

                                @if($isVideo)
                                    <video class="max-h-48 rounded" controls>
                                        <source src="{{ asset($settings['homepage_hero']) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{{ asset($settings['homepage_hero']) }}" 
                                        class="max-h-48 rounded object-contain" 
                                        alt="Hero image">
                                @endif
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('homepage_hero')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Kavling Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Kavling</h2>
                <div>
                    <x-input-label for="kavling_h1" value="H1 Title *" />
                    <x-text-input id="kavling_h1" name="kavling_h1" type="text" class="mt-1 block w-full"
                        :value="old('kavling_h1', $settings['kavling_h1'] ?? '')" required />
                    <x-input-error :messages="$errors->get('kavling_h1')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="kavling_subtitle" value="Subtitle *" />
                    <textarea id="kavling_subtitle" name="kavling_subtitle" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('kavling_subtitle', $settings['kavling_subtitle'] ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('kavling_subtitle')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="kavling_hero" value="Hero (Video/Image) *" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="kavling-hero-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload Hero Media *</span></p>
                                    <p class="text-xs text-gray-500">MP4, PNG, JPG up to 50MB</p>
                                </div>
                            </label>
                            <input id="kavling-hero-upload" name="kavling_hero" type="file"
                                accept="video/mp4,image/jpeg,image/png"
                                style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                aria-label="Upload hero media" />
                        </div>
                        @if(isset($settings['kavling_hero']))
                            <div id="kavling-hero-preview" class="text-center">
                                @php
                                    $extension = pathinfo($settings['kavling_hero'], PATHINFO_EXTENSION);
                                    $isVideo = in_array(strtolower($extension), ['mp4']);
                                @endphp
                                @if($isVideo)
                                    <video class="max-h-48 rounded" controls>
                                        <source src="{{ asset($settings['kavling_hero']) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{{ asset($settings['kavling_hero']) }}"
                                        class="max-h-48 rounded object-contain"
                                        alt="Hero image">
                                @endif
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('kavling_hero')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Layanan Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Layanan</h2>
                <div>
                    <x-input-label for="layanan_h1" value="H1 Title *" />
                    <x-text-input id="layanan_h1" name="layanan_h1" type="text" class="mt-1 block w-full"
                        :value="old('layanan_h1', $settings['layanan_h1'] ?? '')" required />
                    <x-input-error :messages="$errors->get('layanan_h1')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="layanan_subtitle" value="Subtitle *" />
                    <textarea id="layanan_subtitle" name="layanan_subtitle" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('layanan_subtitle', $settings['layanan_subtitle'] ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('layanan_subtitle')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="layanan_hero" value="Hero (Video/Image) *" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="layanan-hero-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload Hero Media *</span></p>
                                    <p class="text-xs text-gray-500">MP4, PNG, JPG up to 50MB</p>
                                </div>
                            </label>
                            <input id="layanan-hero-upload" name="layanan_hero" type="file"
                                accept="video/mp4,image/jpeg,image/png"
                                style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                aria-label="Upload hero media" />
                        </div>
                        @if(isset($settings['layanan_hero']))
                            <div id="layanan-hero-preview" class="text-center">
                                @php
                                    $extension = pathinfo($settings['layanan_hero'], PATHINFO_EXTENSION);
                                    $isVideo = in_array(strtolower($extension), ['mp4']);
                                @endphp
                                @if($isVideo)
                                    <video class="max-h-48 rounded" controls>
                                        <source src="{{ asset($settings['layanan_hero']) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{{ asset($settings['layanan_hero']) }}"
                                        class="max-h-48 rounded object-contain"
                                        alt="Hero image">
                                @endif
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('layanan_hero')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Testimoni Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Testimoni</h2>
                <div>
                    <x-input-label for="testimoni_h1" value="H1 Title *" />
                    <x-text-input id="testimoni_h1" name="testimoni_h1" type="text" class="mt-1 block w-full"
                        :value="old('testimoni_h1', $settings['testimoni_h1'] ?? '')" required />
                    <x-input-error :messages="$errors->get('testimoni_h1')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="testimoni_subtitle" value="Subtitle *" />
                    <textarea id="testimoni_subtitle" name="testimoni_subtitle" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('testimoni_subtitle', $settings['testimoni_subtitle'] ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('testimoni_subtitle')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="testimoni_hero" value="Hero (Video/Image) *" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="testimoni-hero-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload Hero Media *</span></p>
                                    <p class="text-xs text-gray-500">MP4, PNG, JPG up to 50MB</p>
                                </div>
                            </label>
                            <input id="testimoni-hero-upload" name="testimoni_hero" type="file"
                                accept="video/mp4,image/jpeg,image/png"
                                style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                aria-label="Upload hero media" />
                        </div>
                        @if(isset($settings['testimoni_hero']))
                            <div id="testimoni-hero-preview" class="text-center">
                                @php
                                    $extension = pathinfo($settings['testimoni_hero'], PATHINFO_EXTENSION);
                                    $isVideo = in_array(strtolower($extension), ['mp4']);
                                @endphp
                                @if($isVideo)
                                    <video class="max-h-48 rounded" controls>
                                        <source src="{{ asset($settings['testimoni_hero']) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{{ asset($settings['testimoni_hero']) }}"
                                        class="max-h-48 rounded object-contain"
                                        alt="Hero image">
                                @endif
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('testimoni_hero')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Portofolio Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Portofolio</h2>
                <div>
                    <x-input-label for="portofolio_h1" value="H1 Title *" />
                    <x-text-input id="portofolio_h1" name="portofolio_h1" type="text" class="mt-1 block w-full"
                        :value="old('portofolio_h1', $settings['portofolio_h1'] ?? '')" required />
                    <x-input-error :messages="$errors->get('portofolio_h1')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="portofolio_subtitle" value="Subtitle *" />
                    <textarea id="portofolio_subtitle" name="portofolio_subtitle" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('portofolio_subtitle', $settings['portofolio_subtitle'] ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('portofolio_subtitle')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="portofolio_hero" value="Hero (Video/Image) *" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="portofolio-hero-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload Hero Media *</span></p>
                                    <p class="text-xs text-gray-500">MP4, PNG, JPG up to 50MB</p>
                                </div>
                            </label>
                            <input id="portofolio-hero-upload" name="portofolio_hero" type="file"
                                accept="video/mp4,image/jpeg,image/png"
                                style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                aria-label="Upload hero media" />
                        </div>
                        @if(isset($settings['portofolio_hero']))
                            <div id="portofolio-hero-preview" class="text-center">
                                @php
                                    $extension = pathinfo($settings['portofolio_hero'], PATHINFO_EXTENSION);
                                    $isVideo = in_array(strtolower($extension), ['mp4']);
                                @endphp
                                @if($isVideo)
                                    <video class="max-h-48 rounded" controls>
                                        <source src="{{ asset($settings['portofolio_hero']) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{{ asset($settings['portofolio_hero']) }}"
                                        class="max-h-48 rounded object-contain"
                                        alt="Hero image">
                                @endif
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('portofolio_hero')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Galeri Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Galeri</h2>
                <div>
                    <x-input-label for="galeri_h1" value="H1 Title *" />
                    <x-text-input id="galeri_h1" name="galeri_h1" type="text" class="mt-1 block w-full"
                        :value="old('galeri_h1', $settings['galeri_h1'] ?? '')" required />
                    <x-input-error :messages="$errors->get('galeri_h1')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="galeri_subtitle" value="Subtitle *" />
                    <textarea id="galeri_subtitle" name="galeri_subtitle" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('galeri_subtitle', $settings['galeri_subtitle'] ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('galeri_subtitle')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="galeri_hero" value="Hero (Video/Image) *" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="galeri-hero-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload Hero Media *</span></p>
                                    <p class="text-xs text-gray-500">MP4, PNG, JPG up to 50MB</p>
                                </div>
                            </label>
                            <input id="galeri-hero-upload" name="galeri_hero" type="file"
                                accept="video/mp4,image/jpeg,image/png"
                                style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                aria-label="Upload hero media" />
                        </div>
                        @if(isset($settings['galeri_hero']))
                            <div id="galeri-hero-preview" class="text-center">
                                @php
                                    $extension = pathinfo($settings['galeri_hero'], PATHINFO_EXTENSION);
                                    $isVideo = in_array(strtolower($extension), ['mp4']);
                                @endphp
                                @if($isVideo)
                                    <video class="max-h-48 rounded" controls>
                                        <source src="{{ asset($settings['galeri_hero']) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{{ asset($settings['galeri_hero']) }}"
                                        class="max-h-48 rounded object-contain"
                                        alt="Hero image">
                                @endif
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('galeri_hero')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Contact Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Contact Information</h2>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="email" value="Email *" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email', $settings['email'] ?? '')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="whatsapp" value="WhatsApp *" />
                        <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full"
                            :value="old('whatsapp', $settings['whatsapp'] ?? '')" required />
                        <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="alamat" value="Alamat" />
                    <textarea id="alamat" name="alamat" rows="3" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('alamat', $settings['alamat'] ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>
            </div>

            <!-- Social Media Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Social Media</h2>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="instagram" value="Instagram URL" />
                        <x-text-input id="instagram" name="instagram" type="url" class="mt-1 block w-full"
                            :value="old('instagram', $settings['instagram'] ?? '')" />
                        <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="facebook" value="Facebook URL" />
                        <x-text-input id="facebook" name="facebook" type="url" class="mt-1 block w-full"
                            :value="old('facebook', $settings['facebook'] ?? '')" />
                        <x-input-error :messages="$errors->get('facebook')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">SEO Settings</h2>
                
                <div>
                    <x-input-label for="meta_title" value="Meta Title" />
                    <x-text-input id="meta_title" name="meta_title" type="text" class="mt-1 block w-full"
                        :value="old('meta_title', $settings['meta_title'] ?? '')" />
                    <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="meta_description" value="Meta Description" />
                    <textarea id="meta_description" name="meta_description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="meta_keywords" value="Meta Keywords" />
                    <x-text-input id="meta_keywords" name="meta_keywords" type="text" class="mt-1 block w-full"
                        :value="old('meta_keywords', $settings['meta_keywords'] ?? '')" />
                    <x-input-error :messages="$errors->get('meta_keywords')" class="mt-2" />
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Footer</h2>
                
                <div>
                    <x-input-label for="footer_text" value="Footer Text *" />
                    <x-text-input id="footer_text" name="footer_text" type="text" class="mt-1 block w-full"
                        :value="old('footer_text', $settings['footer_text'] ?? '')" required />
                    <x-input-error :messages="$errors->get('footer_text')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <x-secondary-button onclick="history.back()">Cancel</x-secondary-button>
                <x-primary-button>Update Settings</x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Logo Preview
    const logoUpload = document.getElementById('logo-upload');
    const logoPreview = document.getElementById('logo-preview');

    logoUpload?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 1024 * 1024) {
                alert('File size should not exceed 1MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.querySelector('img').src = e.target.result;
                logoPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Favicon Preview
    const faviconUpload = document.getElementById('favicon-upload');
    const faviconPreview = document.getElementById('favicon-preview');

    faviconUpload?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 100 * 1024) { // 100KB
                alert('File size should not exceed 100KB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                faviconPreview.querySelector('img').src = e.target.result;
                faviconPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Hero Media Preview
    const heroUpload = document.getElementById('hero-upload');
    const heroPreview = document.getElementById('hero-preview');

    heroUpload?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 50 * 1024 * 1024) { // 50MB
                alert('File size should not exceed 50MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                if (!heroPreview) return;

                // Clear existing preview
                heroPreview.innerHTML = '';

                if (file.type.startsWith('video/')) {
                    // Video preview
                    const video = document.createElement('video');
                    video.className = 'max-h-48 rounded';
                    video.controls = true;
                    const source = document.createElement('source');
                    source.src = e.target.result;
                    source.type = file.type;
                    video.appendChild(source);
                    heroPreview.appendChild(video);
                } else {
                    // Image preview
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'max-h-48 rounded object-contain';
                    img.alt = 'Hero image';
                    heroPreview.appendChild(img);
                }

                heroPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Hero Media Preview for all sections
    ['kavling', 'layanan', 'testimoni', 'portofolio', 'galeri'].forEach(function(section) {
        const upload = document.getElementById(section + '-hero-upload');
        const preview = document.getElementById(section + '-hero-preview');
        if (upload) {
            upload.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 50 * 1024 * 1024) { // 50MB
                        alert('File size should not exceed 50MB');
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (!preview) return;
                        preview.innerHTML = '';
                        if (file.type.startsWith('video/')) {
                            const video = document.createElement('video');
                            video.className = 'max-h-48 rounded';
                            video.controls = true;
                            const source = document.createElement('source');
                            source.src = e.target.result;
                            source.type = file.type;
                            video.appendChild(source);
                            preview.appendChild(video);
                        } else {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'max-h-48 rounded object-contain';
                            img.alt = 'Hero image';
                            preview.appendChild(img);
                        }
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
});
</script>
@endsection