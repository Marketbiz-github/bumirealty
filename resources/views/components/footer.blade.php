<footer class="bg-[#1E605C] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-semibold mb-2">Head Office</h3>
                    <p class="text-teal-100 mb-4">
                        {{ $settings['alamat'] ?? 'Jl. Bypass Ngurah Rai No.123, Denpasar Selatan, Bali' }}
                    </p>
                </div>

                <!-- Navigation Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home.product') }}" class="text-teal-100 hover:text-white transition">Kavling Berjalan</a></li>
                        <li><a href="{{ route('home.services') }}" class="text-teal-100 hover:text-white transition">Produk Layanan</a></li>
                        <li><a href="{{ route('home.testimonials') }}" class="text-teal-100 hover:text-white transition">Testimoni Konsumen</a></li>
                        <li><a href="{{ route('home.portofolio') }}" class="text-teal-100 hover:text-white transition">Portofolio Project</a></li>
                        <li><a href="{{ route('home.Gallery') }}" class="text-teal-100 hover:text-white transition">Galeri Project</a></li>
                        <li><a href="{{ route('home.articles') }}" class="text-teal-100 hover:text-white transition">Artikel</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact us</h3>
                    <div class="space-y-2">
                        <p class="text-teal-100">
                            <a href="mailto:{{ $settings['email'] ?? 'info@bumirealty.id' }}" class="hover:underline">
                                {{ $settings['email'] ?? 'info@bumirealty.id' }}
                            </a>
                        </p>
                        <p class="text-teal-100">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '6281234567890') }}" target="_blank" class="hover:underline">
                                +{{ $settings['whatsapp'] ?? '62 812-3456-7890' }}
                            </a>
                        </p>
                    </div>
                    <div class="flex space-x-3 mt-4">
                        @if(!empty($settings['facebook']))
                        <a href="{{ $settings['facebook'] }}" target="_blank" class="w-8 h-8 bg-teal-700 rounded-full flex items-center justify-center hover:bg-teal-600 transition">
                            {{-- Facebook SVG --}}
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.522-4.477-10-10-10S2 6.478 2 12c0 5 3.657 9.127 8.438 9.877v-6.987h-2.54v-2.89h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.242 0-1.632.771-1.632 1.562v1.875h2.773l-.443 2.89h-2.33v6.987C18.343 21.127 22 17 22 12"></path></svg>
                        </a>
                        @endif
                        @if(!empty($settings['instagram']))
                        <a href="{{ $settings['instagram'] }}" target="_blank" class="w-8 h-8 bg-teal-700 rounded-full flex items-center justify-center hover:bg-teal-600 transition">
                            {{-- Instagram SVG --}}
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5a5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5zm5.25.75a1 1 0 1 1-2 0a1 1 0 0 1 2 0z"></path></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-t border-teal-700 mt-8 pt-8 text-center">
                <p class="text-teal-100 text-sm">
                    {{ $settings['footer_text'] ?? 'Copyright '.date('Y').' BumiRealty.id All rights reserved' }}
                </p>
            </div>
        </div>
</footer>