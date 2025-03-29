@extends('layouts.company')

@section('title', "{$vehicle->brand} {$vehicle->model}")
@section('header', 'Vehicle Details')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</h2>
            <div class="flex space-x-2">
                <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Edit Vehicle
                </a>
                <a href="{{ route('company.vehicles.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Back to Vehicles
                </a>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="md:flex">
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('company.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('company.vehicles.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors duration-200 md:ml-2">Véhicules</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-indigo-600 md:ml-2">Voir les details</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Photo Gallery Section -->
            <div class="md:w-1/2 p-6">
                @if($vehicle->photos->count() > 0)
                    <div class="mb-4">
                        <img id="main-photo" src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path ?? $vehicle->photos->first()->path) }}" 
                             alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                             class="w-full h-64 object-cover rounded-lg">
                    </div>
                    
                    @if($vehicle->photos->count() > 1)
                        <div class="grid grid-cols-5 gap-2">
                            @foreach($vehicle->photos as $photo)
                                <div class="cursor-pointer" onclick="changeMainPhoto('{{ asset('storage/' . $photo->path) }}')">
                                    <img src="{{ asset('storage/' . $photo->path) }}" 
                                         alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                                         class="h-16 w-full object-cover rounded border-2 {{ $photo->is_primary ? 'border-indigo-500' : 'border-transparent' }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="flex items-center justify-center h-64 bg-gray-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-center text-gray-500 mt-2">No photos available</p>
                @endif
            </div>
            
            <!-- Vehicle Information Section -->
            <div class="md:w-1/2 p-6 bg-gray-50">
                <div class="flex justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-sm text-gray-500">{{ $vehicle->year }} · License: {{ $vehicle->license_plate }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900">{{ number_format($vehicle->price_per_day, 2) }} €/day</p>
                        <div class="flex mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} mr-1">
                                {{ $vehicle->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $vehicle->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Transmission</h4>
                        <p>{{ ucfirst($vehicle->transmission) }}</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Fuel Type</h4>
                        <p>{{ ucfirst($vehicle->fuel_type) }}</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Seats</h4>
                        <p>{{ $vehicle->seats }}</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Total Bookings</h4>
                        <p>{{ $vehicle->reservations->count() ?? 0 }}</p>
                    </div>
                </div>
                
                @if($vehicle->features && count($vehicle->features) > 0)
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Features</h4>
                        <div class="grid grid-cols-2 gap-2">
                            @php
                                $featuresLabels = [
                                    'air_conditioning' => 'Air Conditioning',
                                    'gps' => 'GPS Navigation',
                                    'bluetooth' => 'Bluetooth',
                                    'usb' => 'USB Port',
                                    'heated_seats' => 'Heated Seats',
                                    'sunroof' => 'Sunroof',
                                    'cruise_control' => 'Cruise Control',
                                    'parking_sensors' => 'Parking Sensors',
                                    'backup_camera' => 'Backup Camera',
                                    'child_seats' => 'Child Seats',
                                    'wifi' => 'Wi-Fi',
                                    'leather_seats' => 'Leather Seats'
                                ];
                            @endphp
                            
                            @foreach($vehicle->features as $feature)
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">{{ $featuresLabels[$feature] ?? $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Description</h4>
                    <p class="text-sm text-gray-500">{{ $vehicle->description ?? 'No description available' }}</p>
                </div>

                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Location</h4>
                    <p class="text-sm text-gray-500">{{ $vehicle->location }}</p>
                </div>

                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Created At</h4>
                    <p class="text-sm text-gray-500">{{ $vehicle->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
