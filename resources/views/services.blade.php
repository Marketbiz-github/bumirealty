@extends('layouts.app-landingpage')

@section('meta_title', 'Produk Layanan - BumiRealty')

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
                    Produk Layanan
                </h1>
                <p class="md:text-lg text-white/90">
                    Kami hadir untuk memberikan solusi terbaik bagi kebutuhan Anda. Dengan pengalaman dan tim yang berpengalaman, layanan kami dikembangkan untuk memberikan hasil maksimal.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="md:py-20 py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach($services as $index => $service)
            <div id="{{ $service->slug }}" class="scroll-mt-24 flex items-center {{ !$loop->last ? 'mb-24' : '' }}">
                <div class="flex items-center w-full
                    {{ $index % 2 == 1 ? 'flex-row-reverse space-x-reverse space-x-8' : 'space-x-8' }}">
                    <div class="w-20 h-20 bg-teal-700 rounded-full flex items-center justify-center flex-shrink-0">
                        <img src="{{ $service->icon }}"
                             alt="{{ $service->title }}"
                             class="w-10 h-10">
                    </div>
                    <div class="w-full {{ $index % 2 == 1 ? 'text-right flex flex-col items-end' : '' }}">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $service->title }}</h3>
                        <p class="text-gray-600 max-w-md {{ $index % 2 == 1 ? 'text-right' : '' }}">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection