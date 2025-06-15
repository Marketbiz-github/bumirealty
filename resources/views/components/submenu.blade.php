<x-modal name="product-detail" :show="false" maxWidth="6xl">
    <div x-data="{ imgIdx: 0 }"
        class="p-6 w-full"
        x-init="$watch('$store.productDetail.show', v => { if(v) imgIdx = 0 })">
        
        <!-- Tombol Tutup -->
        <button @click="$store.productDetail.close()"
            class="absolute top-2 right-4 z-10 text-gray-500 hover:text-black text-lg font-bold">
            ✕
        </button>

        <template x-if="$store.productDetail.product">
            <div class="w-full relative flex flex-col md:flex-row">

                <!-- Kiri: Gambar, Judul, Harga -->
                <div class="w-full md:w-2/3 p-4 md:p-6">
                    <!-- Slider Gambar -->
                    <div class="relative w-full h-64 md:h-[28rem] bg-gray-200 rounded overflow-hidden">
                        <template x-for="(img, idx) in $store.productDetail.product.media" :key="img.id">
                            <img x-show="imgIdx === idx"
                                :src="img.url"
                                :alt="$store.productDetail.product.name"
                                class="w-full h-full object-cover transition duration-300 ease-in-out rounded">
                        </template>

                        <!-- Tombol Navigasi -->
                        <button x-show="$store.productDetail.product.media.length > 1"
                            @click="imgIdx = (imgIdx - 1 + $store.productDetail.product.media.length) % $store.productDetail.product.media.length"
                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-orange-600 text-xl px-2 py-1 rounded-full shadow">
                            ‹
                        </button>

                        <button x-show="$store.productDetail.product.media.length > 1"
                            @click="imgIdx = (imgIdx + 1) % $store.productDetail.product.media.length"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-orange-600 text-xl px-2 py-1 rounded-full shadow">
                            ›
                        </button>

                        {{-- img 900 x 600 px  --}}

                        <!-- Indicator -->
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-1">
                            <template x-for="(img, idx) in $store.productDetail.product.media" :key="img.id">
                                <span :class="imgIdx === idx ? 'bg-orange-500' : 'bg-gray-300'"
                                    class="w-2 h-2 rounded-full block"></span>
                            </template>
                        </div>
                    </div>

                    <!-- Judul & Harga -->
                    <h2 class="mt-4 text-xl font-bold text-gray-900" x-text="$store.productDetail.product.name"></h2>
                    <p class="text-teal-700 font-semibold text-lg mb-4">
                        Rp. <span x-text="Number($store.productDetail.product.price).toLocaleString('id-ID')"></span>
                        <template x-if="$store.productDetail.product.attributes.find(a => a.attribute_slug === 'luas-tanah')">
                            <span class="ml-2 text-teal-700 text-sm">
                                / 
                                <span x-text="$store.productDetail.product.attributes.find(a => a.attribute_slug === 'luas-tanah').value"></span>
                            </span>
                        </template>
                    </p>

                    <a 
                        :href="'https://wa.me/' + @js($settings['whatsapp'])"
                        target="_blank"
                        rel="noopener"
                        class="mt-6 px-4 py-2 bg-[#1E605C] text-white text-sm rounded hover:bg-teal-700 flex items-center justify-center gap-2 w-fit"
                    >
                        Chat with us
                    </a>
                </div>

                <!-- Kanan: Deskripsi -->
                <div class="w-full md:w-1/3 p-4 md:pl-0 md:pr-6 md:py-5 max-h-[32rem] overflow-y-auto">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Deskripsi</h3>
                    <hr class="my-4 border-t border-gray-200">

                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <!-- Lokasi Icon -->
                        <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <circle cx="12" cy="11" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <span class="font-semibold mr-1">Lokasi:</span>
                        <span x-text="$store.productDetail.product.attributes.find(a => a.attribute_slug === 'lokasi')?.value || '-'"></span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <!-- Google Maps Icon -->
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10.5a8.38 8.38 0 01-.9 3.8c-.6 1.2-1.5 2.3-2.6 3.2-1.1.9-2.4 1.5-3.8 1.5s-2.7-.6-3.8-1.5c-1.1-.9-2-2-2.6-3.2A8.38 8.38 0 013 10.5C3 6.36 6.36 3 10.5 3S18 6.36 18 10.5z"/>
                            <circle cx="10.5" cy="10.5" r="2.5" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <span class="font-semibold mr-1">Google Maps:</span>
                        <a 
                            :href="$store.productDetail.product.attributes.find(a => a.attribute_slug === 'gmaps-url')?.value || '#'" 
                            class="text-blue-600 underline hover:text-blue-800"
                            target="_blank"
                            rel="noopener"
                            x-text="$store.productDetail.product.attributes.find(a => a.attribute_slug === 'gmaps-url')?.value ? 'Lihat Lokasi' : '-'"
                        ></a>
                    </div>

                    <p class="mt-4 text-sm text-gray-700 whitespace-pre-line" x-html="$store.productDetail.product.description"></p>

                    
                </div>
            </div>
        </template>
    </div>
</x-modal>

<x-modal name="portofolio-detail" :show="false" maxWidth="6xl">
    <div x-data="{ imgIdx: 0 }"
        class="p-6 w-full"
        x-init="$watch('$store.portofolioDetail.show', v => { if(v) imgIdx = 0 })">
        <button @click="$store.portofolioDetail.close()"
            class="absolute top-2 right-4 z-10 text-gray-500 hover:text-black text-lg font-bold">
            ✕
        </button>
        <template x-if="$store.portofolioDetail.portofolio">
            <div class="w-full relative flex flex-col md:flex-row">
                <!-- Kiri: Slider Gambar -->
                <div class="w-full md:w-2/3 p-4 md:p-6">
                    <div class="relative w-full h-64 md:h-[28rem] bg-gray-200 rounded overflow-hidden">
                        <template x-for="(img, idx) in $store.portofolioDetail.portofolio.images" :key="img.id">
                            <img x-show="imgIdx === idx"
                                :src="img.url"
                                :alt="$store.portofolioDetail.portofolio.name"
                                class="w-full h-full object-cover transition duration-300 ease-in-out rounded">
                        </template>
                        <!-- Tombol Navigasi -->
                        <button x-show="$store.portofolioDetail.portofolio.images.length > 1"
                            @click="imgIdx = (imgIdx - 1 + $store.portofolioDetail.portofolio.images.length) % $store.portofolioDetail.portofolio.images.length"
                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-orange-600 text-xl px-2 py-1 rounded-full shadow">
                            ‹
                        </button>
                        <button x-show="$store.portofolioDetail.portofolio.images.length > 1"
                            @click="imgIdx = (imgIdx + 1) % $store.portofolioDetail.portofolio.images.length"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-orange-600 text-xl px-2 py-1 rounded-full shadow">
                            ›
                        </button>
                        <!-- Indicator -->
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-1">
                            <template x-for="(img, idx) in $store.portofolioDetail.portofolio.images" :key="img.id">
                                <span :class="imgIdx === idx ? 'bg-orange-500' : 'bg-gray-300'"
                                    class="w-2 h-2 rounded-full block"></span>
                            </template>
                        </div>
                    </div>
                </div>
                <!-- Kanan: Deskripsi -->
                <div class="w-full md:w-1/3 p-4 md:pl-0 md:pr-6 md:py-5 max-h-[32rem] overflow-y-auto">
                    <h2 class="text-xl font-bold text-gray-900 mb-4" x-text="$store.portofolioDetail.portofolio.name"></h2>
                    <p class="text-gray-700" x-html="$store.portofolioDetail.portofolio.description"></p>
                    <a 
                        :href="'https://wa.me/' + @js($settings['whatsapp'])"
                        target="_blank"
                        rel="noopener"
                        class="mt-6 px-4 py-2 bg-[#1E605C] text-white text-sm rounded hover:bg-teal-700 flex items-center justify-center gap-2 w-fit"
                    >
                        Chat with us
                    </a>
                </div>
            </div>
        </template>
    </div>
</x-modal>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('productDetail', {
            show: false,
            product: null,
            open(product) {
                this.product = product;
                this.show = true;
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'product-detail' }));
            },
            close() {
                this.show = false;
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'product-detail' }));
            }
        });

        // Portofolio modal store
        Alpine.store('portofolioDetail', {
            show: false,
            portofolio: null,
            open(portofolio) {
                this.portofolio = portofolio;
                this.show = true;
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'portofolio-detail' }));
            },
            close() {
                this.show = false;
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'portofolio-detail' }));
            }
        });
    });
</script>