@extends('layouts.company')

@section('title', 'Manage Promotions')
@section('header', 'Offers & Promotions')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Your Promotional Offers</h2>
        <a href="{{ route('company.promotions.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Create New Promotion
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
</div>

<!-- Promotion Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Active Promotions Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Active Promotions</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['active_count'] }}</p>
        </div>
        <div class="bg-green-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>
        </div>
    </div>
    
    <!-- Upcoming Promotions Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Upcoming Promotions</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['upcoming_count'] }}</p>
        </div>
        <div class="bg-blue-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    
    <!-- Average Discount Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Average Discount</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['avg_discount'] ?? 0, 1) }}%</p>
        </div>
        <div class="bg-yellow-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
        </div>
    </div>
    
    <!-- Revenue With Promotions Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Revenue with Promotions</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['revenue_with_promotions'] ?? 0, 2) }} €</p>
        </div>
        <div class="bg-purple-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
</div>

<!-- Active Promotions Section -->
@if($activePromotions->count() > 0)
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Active Promotions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($activePromotions as $promotion)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-5 bg-gradient-to-r from-green-500 to-teal-400">
                        <div class="flex justify-between items-center">
                            <h4 class="text-xl font-bold text-white">{{ $promotion->name }}</h4>
                            <span class="px-3 py-1 bg-white text-green-700 text-sm font-semibold rounded-full">{{ $promotion->discount_percentage }}% OFF</span>
                        </div>
                    </div>
                    <div class="p-5">
                        @if($promotion->description)
                            <p class="text-gray-600 mb-4">{{ Str::limit($promotion->description, 100) }}</p>
                        @endif
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Start: {{ \Carbon\Carbon::parse($promotion->start_date)->format('M d, Y') }}
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                End: {{ \Carbon\Carbon::parse($promotion->end_date)->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ $promotion->reservations_count ?? 0 }} use{{ ($promotion->reservations_count ?? 0) != 1 ? 's' : '' }}
                            </span>
                            <div>
                                <a href="{{ route('company.promotions.edit', $promotion) }}" class="text-sm text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                <a href="{{ route('company.promotions.show', $promotion) }}" class="text-sm text-blue-600 hover:text-blue-900">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-8 mb-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune promotion active</h3>
        <p class="mt-1 text-gray-500">Vous n'avez pas de promotions actuellement actives.</p>
        <div class="mt-6 flex justify-center">
            <a href="{{ route('company.promotions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Créer une promotion
            </a>
            @if($stats['upcoming_count'] > 0)
                <a href="#upcoming-promotions" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Voir les promotions à venir
                </a>
            @endif
        </div>
    </div>
@endif


<!-- Upcoming Promotions Section -->
@if($upcomingPromotions->count() > 0)
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Upcoming Promotions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($upcomingPromotions as $promotion)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-5 bg-gradient-to-r from-blue-500 to-indigo-400">
                        <div class="flex justify-between items-center">
                            <h4 class="text-xl font-bold text-white">{{ $promotion->name }}</h4>
                            <span class="px-3 py-1 bg-white text-blue-700 text-sm font-semibold rounded-full">{{ $promotion->discount_percentage }}% OFF</span>
                        </div>
                    </div>
                    <div class="p-5">
                        @if($promotion->description)
                            <p class="text-gray-600 mb-4">{{ Str::limit($promotion->description, 100) }}</p>
                        @endif
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Start: {{ \Carbon\Carbon::parse($promotion->start_date)->format('M d, Y') }}
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                End: {{ \Carbon\Carbon::parse($promotion->end_date)->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Starts in {{ now()->diffInDays($promotion->start_date) }} days
                            </span>
                            <div>
                                <a href="{{ route('company.promotions.edit', $promotion) }}" class="text-sm text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                <a href="{{ route('company.promotions.show', $promotion) }}" class="text-sm text-blue-600 hover:text-blue-900">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection