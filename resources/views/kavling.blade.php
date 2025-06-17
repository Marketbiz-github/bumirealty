@extends('layouts.app-landingpage')

@section('meta_title', 'Kavling Berjalan - BumiRealty')

@section('content')
<!-- Hero Section -->
<section class="relative h-[480px] flex items-center pt-16 overflow-hidden bg-gray-100">
    @php
        $heroPath = $settings['kavling_hero'] ?? '/images/contents/vid.mp4';
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
        <img src="{{ $settings['kavling_hero'] }}"
            alt="Banner"
            class="absolute inset-0 w-full h-full object-cover z-0">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40 z-10"></div>

        <!-- Container dengan width yang sama persis dengan navbar -->
        <div class="relative z-20 w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="w-full md:w-2/3 lg:w-1/2 text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        {{ $settings['kavling_h1'] }}
                    </h1>
                    <p class="md:text-lg text-white/90">
                        {{ $settings['kavling_subtitle'] }}                
                    </p>
                </div>
            </div>
        </div>
    @endif
</section>

<!-- Kavling Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div 
            x-data="{
                products: @js($products),
                perPage: 8,
                currentPage: 1,
                sortBy: 'created_at',
                sortDir: 'desc',
                get sortedProducts() {
                    return [...this.products].sort((a, b) => {
                        if(this.sortBy === 'price') {
                            return this.sortDir === 'asc' ? a.price - b.price : b.price - a.price;
                        }
                        return this.sortDir === 'asc' 
                            ? a[this.sortBy].localeCompare(b[this.sortBy])
                            : b[this.sortBy].localeCompare(a[this.sortBy]);
                    });
                },
                get paginatedProducts() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.sortedProducts.slice(start, start + this.perPage);
                },
                get totalPages() {
                    return Math.ceil(this.products.length / this.perPage);
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
                        <option value="price">Harga</option>
                        <option value="name">Nama</option>
                    </select>
                    <button @click="sortDir = sortDir === 'asc' ? 'desc' : 'asc'"
                            class="px-3 py-2 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        <span x-text="sortDir === 'asc' ? '↑' : '↓'"></span>
                    </button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="product in paginatedProducts" :key="product.id">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow flex flex-col">
                        <template x-if="product.thumbnail_url">
                            <img :src="product.thumbnail_url" :alt="product.name" class="h-48 w-full object-cover">
                        </template>
                        <template x-if="!product.thumbnail_url">
                            <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                        </template>
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="font-semibold text-gray-900 mb-2" x-text="product.name"></h3>
                            <p class="text-sm text-[#1E605C] font-bold mb-4">
                                Rp. <span x-text="Number(product.price).toLocaleString('id-ID')"></span>
                                <template x-if="product.attributes.find(a => a.attribute_slug === 'luas-tanah')">
                                    <span class="ml-2 text-xs text-[#1E605C] font-bold">
                                        / <span x-text="product.attributes.find(a => a.attribute_slug === 'luas-tanah').value"></span> 
                                    </span>
                                </template>
                            </p>
                            <div class="mt-auto">
                                <p class="text-xs text-gray-500 mb-2">
                                    <svg class="inline w-4 h-4 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <circle cx="12" cy="11" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                                    </svg>
                                    <span x-text="product.attributes.find(a => a.attribute_slug === 'lokasi')?.value || '-'"></span>
                                </p>
                                <span
                                    @click="$store.productDetail.open(product)"
                                    class="w-full inline-flex justify-start items-center pb-2 text-orange-500 font-bold text-sm cursor-pointer hover:underline transition ease-in-out duration-150">
                                    Learn more
                                </span>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="paginatedProducts.length === 0">
                    <div class="col-span-4 text-center text-gray-500">Belum ada kavling berjalan.</div>
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