@extends('layouts.app-landingpage')

@section('meta_title', 'Testimonial Konsumen - BumiRealty')

@section('content')
<!-- Hero Section -->
<section class="relative h-[480px] flex items-center pt-16 overflow-hidden bg-gray-100">
    <!-- Background Image -->
    <img src="/images/contents/bg.png"
         alt="Banner"
         class="absolute inset-0 w-full h-full object-cover z-0">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 z-10"></div>

    <!-- Container dengan width yang sama persis dengan navbar -->
    <div class="relative z-20 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="w-full md:w-2/3 lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Testimonial Konsumen
                </h1>
                <p class="md:text-lg text-white/90">
                    Apa kata mereka yang telah menggunakan jasa BumiRealty.id
                </p>
            </div>
        </div>
    </div>
</section>

<section class="md:py-20 py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div 
            x-data="{
                testimonials: @js($testimonials),
                perPage: 8,
                currentPage: 1,
                sortBy: 'created_at',
                sortDir: 'desc',
                get sortedTestimonials() {
                    return [...this.testimonials].sort((a, b) => {
                        if(this.sortBy === 'name') {
                            return this.sortDir === 'asc'
                                ? a.name.localeCompare(b.name)
                                : b.name.localeCompare(a.name);
                        }
                        if(this.sortBy === 'rating') {
                            return this.sortDir === 'asc'
                                ? (a.rating ?? 0) - (b.rating ?? 0)
                                : (b.rating ?? 0) - (a.rating ?? 0);
                        }
                        // Default: sort by created_at (assume string date or timestamp)
                        return this.sortDir === 'asc'
                            ? String(a.created_at).localeCompare(String(b.created_at))
                            : String(b.created_at).localeCompare(String(a.created_at));
                    });
                },
                get paginatedTestimonials() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.sortedTestimonials.slice(start, start + this.perPage);
                },
                get totalPages() {
                    return Math.ceil(this.testimonials.length / this.perPage);
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
                        <option value="rating">Rating</option>
                    </select>
                    <button @click="sortDir = sortDir === 'asc' ? 'desc' : 'asc'"
                            class="px-3 py-2 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        <span x-text="sortDir === 'asc' ? '↑' : '↓'"></span>
                    </button>
                </div>
            </div>

            <!-- Testimonial Grid -->
            <div class="grid grid-cols-1 gap-8">
                <template x-for="testimonial in paginatedTestimonials" :key="testimonial.id">
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
                <template x-if="paginatedTestimonials.length === 0">
                    <div class="col-span-2 text-center text-gray-500">Belum ada testimonial.</div>
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