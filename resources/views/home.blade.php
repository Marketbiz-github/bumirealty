@extends('layouts.app-landingpage')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-16 overflow-hidden">
        <!-- Background Video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ $settings['homepage_hero'] ?? '/images/contents/vid.mp4' }}" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
        
        <!-- SEO h1 (invisible but accessible) -->
        <h1 class="sr-only">{{ $settings['homepage_h1'] ?? 'Kavling Strategis Lokasi Premium - Investasi Menguntungkan' }}</h1>

    
    </section>


    <!-- Kavling Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-12">
                <!-- Kiri -->
                <div class="md:w-1/2 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Kavling yang sedang berjalan</h2>
                </div>

                <!-- Kanan -->
                <div class="md:w-1/2 text-center md:text-left">
                    <p class="text-gray-600 max-w-xl md:mx-0 mx-auto">
                        Jangan lewatkan kesempatan emas untuk memiliki kavling strategis di lokasi premium yang menjanjikan untuk kepentingan investasi yang menguntungkan.
                    </p>
                </div>
            </div>

            
            <div 
                x-data="{
                    idx: 0,
                    products: @js($products),
                    visible: 4,
                    get shown() {
                        return this.products.slice(this.idx, this.idx + this.visible);
                    },
                    prev() {
                        if (this.idx > 0) this.idx -= this.visible;
                    },
                    next() {
                        if (this.idx < this.products.length - this.visible) this.idx += this.visible;
                    }
                }"
            >
                <div class="flex justify-end items-center mb-6">
                    <span class="text-orange-500 font-bold text-sm cursor-pointer hover:underline transition ease-in-out duration-150 mr-4">See all</span>
                    <div class="flex space-x-2">
                        <button @click="prev" :disabled="idx === 0"
                            class="w-8 h-8 bg-orange-500 text-white rounded hover:bg-orange-600 transition disabled:opacity-50">‹</button>
                        <button @click="next" :disabled="idx >= products.length - visible"
                            class="w-8 h-8 bg-orange-500 text-white rounded hover:bg-orange-600 transition disabled:opacity-50">›</button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <template x-for="product in shown" :key="product.id">
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
                                            / <span x-text="product.attributes.find(a => a.attribute_slug === 'luas-tanah').value"></span> m<sup>2</sup>
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
                    <template x-if="shown.length === 0">
                        <div class="col-span-4 text-center text-gray-500">Belum ada kavling berjalan.</div>
                    </template>
                </div>
            </div>

        </div>
    </section>

    <!-- Produk Layanan Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Produk layanan kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Kami hadir untuk memberikan solusi terbaik bagi kebutuhan Anda. Dengan pengalaman dan tim yang berpengalaman, layanan kami dikembangkan untuk memberikan hasil maksimal.
                </p>
            </div>

            <div x-data="{ idx: 0, interval: null, services: {{ json_encode($services) }} }" 
                x-init="interval = setInterval(() => { if(idx < services.length - 1) { idx++ } }, 2000);"
                @mouseenter="clearInterval(interval)" 
                @mouseleave="interval = setInterval(() => { if(idx < services.length - 1) { idx++ } }, 2000);"
                class="relative">
                <div class="flex justify-center">
                    <template x-for="(service, i) in services" :key="i">
                        <div x-show="idx === i" class="bg-white rounded-lg shadow-lg p-8 max-w-md text-center mx-auto transition-all duration-300">
                            <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <img :src="service.icon" alt="" class="w-8 h-8 object-contain">
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-4" x-text="service.title ?? '-'"></h3>
                            <p class="text-gray-600 mb-4" x-text="service.description ?? '-'"></p>
                        </div>
                    </template>
                </div>
                <!-- Dots Indicator -->
                <div class="flex justify-center mt-8 space-x-2">
                    <template x-for="(service, i) in services" :key="i">
                        <button
                            @click="idx = i"
                            :class="idx === i ? 'bg-[#1E605C]' : 'bg-gray-400'"
                            class="w-2 h-2 rounded-full transition-colors"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimoni Section --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-6">
                <!-- Kiri -->
                <div class="md:w-1/2 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Testimoni konsumen</h2>
                </div>

                <!-- Kanan -->
                <div class="md:w-1/2 text-center md:text-left">
                    <p class="text-gray-600 max-w-xl md:mx-0 mx-auto">
                        Apa kata mereka yang telah bergabung dari BumiRealty.id
                    </p>
                </div>
            </div>
            <div 
                x-data="{
                    idx: 0,
                    testimonials: @js($testimonials),
                    visible: 2, // tampilkan 2 testimoni per slide
                    get shown() {
                        return this.testimonials.slice(this.idx, this.idx + this.visible);
                    },
                    prev() {
                        if (this.idx > 0) this.idx--;
                    },
                    next() {
                        if (this.idx < this.testimonials.length - this.visible) this.idx++;
                    }
                }"
            >
                
                <div class="flex justify-end items-center mb-6">
                    <span class="text-orange-500 font-bold text-sm cursor-pointer hover:underline transition ease-in-out duration-150 mr-4">See all</span>
                    <div class="flex space-x-2">
                        <button @click="prev" :disabled="idx === 0"
                            class="w-8 h-8 bg-orange-500 text-white rounded hover:bg-orange-600 transition disabled:opacity-50">‹</button>
                        <button @click="next" :disabled="idx >= testimonials.length - visible"
                            class="w-8 h-8 bg-orange-500 text-white rounded hover:bg-orange-600 transition disabled:opacity-50">›</button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <template x-for="testimonial in shown" :key="testimonial.id">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="font-semibold text-gray-900 mb-2" x-text="testimonial.name"></h3>
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    <template x-for="i in testimonial.rating">
                                        <span>★</span>
                                    </template>
                                </div>
                            </div>
                            <p class="text-gray-600 mt-2" x-text="testimonial.message"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Portofolio Project Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-12">
                <!-- Kiri -->
                <div class="md:w-1/2 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Portofolio project</h2>
                </div>
                <!-- Kanan -->
                <div class="md:w-1/2 text-center md:text-left">
                    <p class="text-gray-600 max-w-xl md:mx-0 mx-auto">
                        Kumpulan hasil kerja terbaik kami dalam berbagai bidang, setiap proyek mencerminkan komitmen kami terhadap kualitas, inovasi, serta kepuasan klien.
                    </p>
                </div>
            </div>

            <div 
                x-data="{
                    idx: 0,
                    portofolios: @js($portofolios),
                    visible: 4,
                    get shown() {
                        return this.portofolios.slice(this.idx, this.idx + this.visible);
                    },
                    prev() {
                        if (this.idx > 0) this.idx -= this.visible;
                    },
                    next() {
                        if (this.idx < this.portofolios.length - this.visible) this.idx += this.visible;
                    }
                }"
            >
                <div class="flex justify-end items-center mb-6">
                    <span class="text-orange-500 font-bold text-sm cursor-pointer hover:underline transition ease-in-out duration-150 mr-4">See all</span>
                    <div class="flex space-x-2">
                        <button @click="prev" :disabled="idx === 0"
                            class="w-8 h-8 bg-orange-500 text-white rounded hover:bg-orange-600 transition disabled:opacity-50">‹</button>
                        <button @click="next" :disabled="idx >= portofolios.length - visible"
                            class="w-8 h-8 bg-orange-500 text-white rounded hover:bg-orange-600 transition disabled:opacity-50">›</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <template x-for="portofolio in shown" :key="portofolio.id">
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
                    <template x-if="shown.length === 0">
                        <div class="col-span-4 text-center text-gray-500">Belum ada portofolio.</div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Galeri Project Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Galeri Project</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                @foreach($gallery->take(6) as $item)
                    <div class="bg-gray-200 h-64 rounded-lg hover:shadow-lg transition-shadow cursor-pointer overflow-hidden">
                        <img src="{{ $item->url }}" alt="Gallery" class="w-full h-full object-cover">
                    </div>
                @endforeach
                @if($gallery->count() === 0)
                    <div class="col-span-3 text-center text-gray-500">Belum ada galeri.</div>
                @endif
            </div>

            <div class="flex justify-center mb-8">
                <span class="text-orange-500 font-bold text-center text-sm cursor-pointer hover:underline transition ease-in-out duration-150">See all</span>
            </div>
        </div>
    </section>

    <!-- Artikel Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Artikel</h2>
                    <p class="text-gray-600">Cari tahu lebih lanjut tentang aktivitas kami.</p>
                </div>
            </div>

            <div class="flex justify-end items-center mb-6">
                <span class="text-orange-500 font-bold text-sm cursor-pointer hover:underline transition ease-in-out duration-150 mr-4">See all</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($articles as $article)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 bg-gray-200">
                            @if($article['thumbnail'])
                                <img src="{{ $article['thumbnail'] }}" alt="Artikel" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-4">
                            {{-- Judul tidak tersedia di format baru, tampilkan "Artikel" --}}
                            <h3 class="font-semibold text-gray-900 mb-2">Artikel</h3>
                            <p class="text-xs text-gray-500 mb-3">
                                {{ \Carbon\Carbon::parse($article['date'])->format('d M Y') }}
                            </p>
                            <a href="{{ $article['url'] }}" target="_blank" class="w-full inline-flex justify-start items-center pb-2 text-orange-500 font-bold text-sm cursor-pointer hover:underline transition ease-in-out duration-150">
                                Read more
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500">Belum ada artikel.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    
@endsection