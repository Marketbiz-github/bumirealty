@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="">
    <x-breadcrumb />

    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Kavling Stats -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-teal-50">
                        <i class="fas fa-home w-6 h-6 text-teal-600"></i>
                    </div>
                    <div class="ml-5">
                        <h3 class="font-medium text-gray-900">Total Kavling</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-700">{{ $stats['products'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan Stats -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-50">
                        <i class="fas fa-handshake w-6 h-6 text-blue-600"></i>
                    </div>
                    <div class="ml-5">
                        <h3 class="font-medium text-gray-900">Total Layanan</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-700">{{ $stats['services'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonial Stats -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-50">
                        <i class="fas fa-star w-6 h-6 text-yellow-600"></i>
                    </div>
                    <div class="ml-5">
                        <h3 class="font-medium text-gray-900">Total Testimonial</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-700">{{ $stats['testimonials'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portofolio Stats -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-50">
                        <i class="fas fa-briefcase w-6 h-6 text-purple-600"></i>
                    </div>
                    <div class="ml-5">
                        <h3 class="font-medium text-gray-900">Total Portofolio</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-700">{{ $stats['portofolios'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Stats -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-pink-50">
                        <i class="fas fa-images w-6 h-6 text-pink-600"></i>
                    </div>
                    <div class="ml-5">
                        <h3 class="font-medium text-gray-900">Total Gallery</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-700">{{ $stats['galleries'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection