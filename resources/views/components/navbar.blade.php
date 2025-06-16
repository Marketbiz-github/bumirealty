<?php
    $menus = [
        ['label' => 'Beranda', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'Kavling Berjalan', 'href' => route('home.product'), 'dropdown' => true, 'type' => 'product'],
        ['label' => 'Produk Layanan', 'href' => route('home.services'), 'dropdown' => true, 'type' => 'service'],
        ['label' => 'Testimoni Konsumen', 'href' => route('home.testimonials')],
        ['label' => 'Portofolio Project', 'href' => route('home.portofolio'), 'dropdown' => true, 'type' => 'portofolio'],
        ['label' => 'Galeri Project', 'href' => route('home.Gallery')],
        ['label' => 'Artikel', 'href' => route('home.articles')],
    ];
?>

<nav class="bg-white shadow-sm fixed w-full top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="/" class="flex-shrink-0 flex items-center space-x-3">
                <img src="/images/contents/bumirealty.png" alt="BumiRealty Logo" class="h-14 w-auto md:h-16" loading="eager" fetchpriority="high">
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    @foreach($menus as $menu)
                        @if(!empty($menu['dropdown']))
                            <x-dropdown align="left" width="100">
                                <x-slot name="trigger">
                                    <button
                                        @mouseenter="open = true"
                                        @mouseleave="open = false"
                                        class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition"
                                    >
                                        {{ $menu['label'] }}
                                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="w-96" @mouseenter="open = true" @mouseleave="open = false">
                                        @if(isset($menu['type']) && $menu['type'] === 'service')
                                            @foreach($services as $service)
                                                <a href="{{ route('home.services') }}#{{ $service->slug }}"
                                                   class="block w-full px-4 py-4 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                    {{ $service->title }}
                                                </a>
                                            @endforeach
                                        @elseif(isset($menu['type']) && $menu['type'] === 'portofolio')
                                            @foreach($portofolios->take(5) as $portofolio)
                                                <a href="#"
                                                   @click.prevent="$store.portofolioDetail.open(@js($portofolio))"
                                                   class="block w-full px-4 py-4 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                    {{ $portofolio->name }}
                                                </a>
                                            @endforeach
                                            @if($portofolios->count() > 5)
                                                <a href="{{ route('home.portofolio') }}"
                                                   class="block w-full px-4 py-2 text-sm font-semibold text-orange-500 hover:underline">
                                                    See more
                                                </a>
                                            @endif
                                        @else
                                            @foreach($products->take(5) as $product)
                                                <a href="#"
                                                   @click.prevent="$store.productDetail.open(@js($product))"
                                                   class="block w-full px-4 py-4 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                    {{ $product->name }}
                                                </a>
                                            @endforeach
                                            @if($products->count() > 5)
                                                <a href="{{ route('home.product') }}"
                                                   class="block w-full px-4 py-2 text-sm font-semibold text-orange-500 hover:underline">
                                                    See more
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        @else
                            <a href="{{ $menu['href'] }}"
                               class="inline-flex items-center px-1 pt-1 border-b-2 {{ !empty($menu['active']) ? 'border-[#1E605C] text-[#1E605C] font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-teal-700 transition duration-150 ease-in-out">
                                {{ $menu['label'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- CTA Button -->
            <div class="hidden md:block">
                <a 
                    href="https://wa.me/{{ $settings['whatsapp'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#1E605C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-700 focus:ring-offset-2 transition ease-in-out duration-150">
                    Chat with us
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
            @foreach($menus as $menu)
                @if(!empty($menu['dropdown']))
                    <div x-data="{ dropdownOpen: false }">
                        <button
                            @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-teal-700 focus:bg-teal-100 focus:border-teal-700 transition duration-150 ease-in-out"
                        >
                            {{ $menu['label'] }}
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="dropdownOpen" x-transition class="pl-6">
                            @if(isset($menu['type']) && $menu['type'] === 'service')
                                @foreach($services as $service)
                                    <a href="{{ route('home.services') }}#{{ $service->slug }}"
                                       class="block w-full px-4 py-4 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ $service->title }}
                                    </a>
                                @endforeach
                            @elseif(isset($menu['type']) && $menu['type'] === 'portofolio')
                                @foreach($portofolios->take(5) as $portofolio)
                                    <a href="#"
                                       @click.prevent="$store.portofolioDetail.open(@js($portofolio)); open = false"
                                       class="block w-full px-4 py-4 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ $portofolio->name }}
                                    </a>
                                @endforeach
                                @if($portofolios->count() > 5)
                                    <a href="{{ route('home.portofolio') }}"
                                       class="block w-full px-4 py-2 text-sm font-semibold text-orange-500 hover:underline">
                                        See more
                                    </a>
                                @endif
                            @else
                                @foreach($products->take(5) as $product)
                                    <a href="#"
                                       @click.prevent="$store.productDetail.open(@js($product)); open = false"
                                       class="block w-full px-4 py-4 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        {{ $product->name }}
                                    </a>
                                @endforeach
                                @if($products->count() > 5)
                                    <a href="{{ route('home.product') }}"
                                       class="block w-full px-4 py-2 text-sm font-semibold text-orange-500 hover:underline">
                                        See more
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                @else
                    <a href="{{ $menu['href'] }}"
                       class="block w-full ps-3 pe-4 py-2 border-l-4 {{ !empty($menu['active']) ? 'border-[#1E605C] text-teal-700 bg-teal-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-start text-base font-medium focus:outline-none focus:text-teal-700 focus:bg-teal-100 focus:border-[#1E605C] transition duration-150 ease-in-out">
                        {{ $menu['label'] }}
                    </a>
                @endif
            @endforeach
            <div class="px-3 py-2">
                <a 
                    href="https://wa.me/{{ $settings['whatsapp'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#1E605C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-700 focus:ring-offset-2 transition ease-in-out duration-150">
                    Chat with us
                </a>
            </div>
        </div>
    </div>
</nav>