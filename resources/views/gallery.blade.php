@extends('layouts.app-landingpage')

@section('meta_title', 'Galeri Project - BumiRealty')

@section('content')
<!-- Hero Section -->
<section class="relative h-[480px] flex items-center pt-16 overflow-hidden bg-gray-100">
    @php
        $heroPath = $settings['galeri_hero'] ?? '/images/contents/vid.mp4';
        $extension = pathinfo($heroPath, PATHINFO_EXTENSION);
        $isVideo = in_array(strtolower($extension), ['mp4']);
    @endphp

    @if($isVideo)
        <!-- Background Video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset($heroPath) }}" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
    @else
        <!-- Background Image -->
        <img src="{{ $settings['galeri_hero'] }}"
            alt="Banner"
            class="absolute inset-0 w-full h-full object-cover z-0">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40 z-10"></div>

        <!-- Container dengan width yang sama persis dengan navbar -->
        <div class="relative z-20 w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="w-full md:w-2/3 lg:w-1/2 text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        {{ $settings['galeri_h1'] }}
                    </h1>
                    <p class="md:text-lg text-white/90">
                        {{ $settings['galeri_subtitle'] }}                
                    </p>
                </div>
            </div>
        </div>
    @endif
</section>

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div 
            x-data="{
                gallery: @js($gallery),
                perPage: 12,
                currentPage: 1,
                sortBy: 'created_at',
                sortDir: 'desc',
                get sortedGallery() {
                    return [...this.gallery].sort((a, b) => {
                        return this.sortDir === 'asc'
                            ? String(a[this.sortBy]).localeCompare(String(b[this.sortBy]))
                            : String(b[this.sortBy]).localeCompare(String(a[this.sortBy]));
                    });
                },
                get paginatedGallery() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.sortedGallery.slice(start, start + this.perPage);
                },
                get totalPages() {
                    return Math.ceil(this.gallery.length / this.perPage);
                },
                changePage(page) {
                    if(page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                }
            }"
        >
            <!-- Sort Controls -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-4">
                    <select x-model="sortBy" 
                            class="rounded-md text-sm border-gray-300 shadow-sm focus:border-teal-700 focus:ring focus:ring-teal-700 focus:ring-opacity-50">
                        <option value="created_at">Terbaru</option>
                    </select>
                    <button @click="sortDir = sortDir === 'asc' ? 'desc' : 'asc'"
                            class="px-3 py-2 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        <span x-text="sortDir === 'asc' ? '↑' : '↓'"></span>
                    </button>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <template x-for="item in paginatedGallery" :key="item.id">
                    <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow">
                        <img :src="item.url" 
                             :alt="'Gallery Image'" 
                             class="w-full h-64 object-cover transform transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-opacity flex items-center justify-center">
                            <button @click="$dispatch('img-modal', { imgModalSrc: item.url })"
                                    class="p-2 bg-white rounded-full opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all">
                                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center gap-2">
                <button @click="changePage(currentPage - 1)" 
                        :disabled="currentPage === 1"
                        class="px-4 py-2 bg-white border rounded-md hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Previous
                </button>
                
                <template x-for="page in totalPages">
                    <button @click="changePage(page)"
                            :class="currentPage === page ? 'bg-teal-600 text-white' : 'bg-white'"
                            class="px-4 py-2 border rounded-md hover:bg-teal-700 hover:text-white transition">
                        <span x-text="page"></span>
                    </button>
                </template>

                <button @click="changePage(currentPage + 1)"
                        :disabled="currentPage === totalPages"
                        class="px-4 py-2 bg-white border rounded-md hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Next
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for Image Preview -->
    <div x-data="{ imgModal: false, imgModalSrc: '' }"
         @img-modal.window="imgModal = true; imgModalSrc = $event.detail.imgModalSrc"
         x-show="imgModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
         x-cloak>
        <div @click.away="imgModal = false" class="max-w-3xl h-auto p-4">
            <img :src="imgModalSrc" class="h-auto w-full" />
            <button @click="imgModal = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</section>
@endsection