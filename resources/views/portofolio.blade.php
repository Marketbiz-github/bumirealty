@extends('layouts.app-landingpage')

@section('meta_title', 'Portofolio Project - BumiRealty')

@section('content')
<!-- Hero Section -->
<section class="relative h-[480px] flex items-center pt-16 overflow-hidden bg-gray-100">
    @php
        $heroPath = $settings['portofolio_hero'] ?? '/images/contents/vid.mp4';
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
        <img src="{{ $settings['portofolio_hero'] }}"
            alt="Banner"
            class="absolute inset-0 w-full h-full object-cover z-0">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40 z-10"></div>

        <!-- Container dengan width yang sama persis dengan navbar -->
        <div class="relative z-20 w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="w-full md:w-2/3 lg:w-1/2 text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        {{ $settings['portofolio_h1'] }}
                    </h1>
                    <p class="md:text-lg text-white/90">
                        {{ $settings['portofolio_subtitle'] }}               
                    </p>
                </div>
            </div>
        </div>
    @endif
</section>

<!-- Portofolio Project Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div 
            x-data="{
                portofolios: @js($portofolios),
                perPage: 8,
                currentPage: 1,
                sortBy: 'created_at',
                sortDir: 'desc',
                get sortedPortofolios() {
                    return [...this.portofolios].sort((a, b) => {
                        return this.sortDir === 'asc' 
                            ? a[this.sortBy].localeCompare(b[this.sortBy])
                            : b[this.sortBy].localeCompare(a[this.sortBy]);
                    });
                },
                get paginatedPortofolios() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.sortedPortofolios.slice(start, start + this.perPage);
                },
                get totalPages() {
                    return Math.ceil(this.portofolios.length / this.perPage);
                },
                changePage(page) {
                    if(page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                }
            }"
        >
            <!-- Sort Controls -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-4">
                    <select x-model="sortBy" 
                            class="rounded-md text-sm border-gray-300 shadow-sm focus:border-teal-700 focus:ring focus:ring-teal-700 focus:ring-opacity-50">
                        <option value="created_at">Terbaru</option>
                        <option value="name">Nama</option>
                    </select>
                    <button @click="sortDir = sortDir === 'asc' ? 'desc' : 'asc'"
                            class="px-3 py-2 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        <span x-text="sortDir === 'asc' ? '↑' : '↓'"></span>
                    </button>
                </div>
            </div>

            <!-- Portofolio Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="portofolio in paginatedPortofolios" :key="portofolio.id">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow flex flex-col">
                        <template x-if="portofolio.thumbnail_url">
                            <img :src="portofolio.thumbnail_url" :alt="portofolio.name" class="h-48 w-full object-cover">
                        </template>
                        <template x-if="!portofolio.thumbnail_url">
                            <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                        </template>
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-semibold text-gray-900 mb-2" x-text="portofolio.name"></h3>
                            <span
                                @click="$store.portofolioDetail.open(portofolio)"
                                class="w-full inline-flex justify-start items-center pb-2 text-orange-500 font-bold text-sm cursor-pointer hover:underline transition ease-in-out duration-150">
                                Learn more
                            </span>
                        </div>
                    </div>
                </template>
                <template x-if="paginatedPortofolios.length === 0">
                    <div class="col-span-4 text-center text-gray-500">Belum ada portofolio.</div>
                </template>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center gap-2">
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
</section>
@endsection