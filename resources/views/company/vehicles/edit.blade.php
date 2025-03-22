@extends('layouts.company')

@section('title', 'Edit Vehicle')
@section('header', 'Edit Vehicle')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Edit Vehicle: {{ $vehicle->brand }} {{ $vehicle->model }}</h2>
            <a href="{{ route('company.vehicles.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                Back to Vehicles
            </a>
        </div>
    </div>
    
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Please fix the following errors:</p>
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form method="POST" action="{{ route('company.vehicles.update', $vehicle) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $vehicle->brand) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                        <input type="text" name="model" id="model" value="{{ old('model', $vehicle->model) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                        <input type="number" name="year" id="year" value="{{ old('year', $vehicle->year) }}" min="1900" max="{{ date('Y') + 1 }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <div>
                        <label for="license_plate" class="block text-sm font-medium text-gray-700">License Plate</label>
                        <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate', $vehicle->license_plate) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                
                <!-- Technical Details -->
                <div class="space-y-4">
                    <div>
                        <label for="transmission" class="block text-sm font-medium text-gray-700">Transmission</label>
                        <select name="transmission" id="transmission" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="automatic" {{ old('transmission', $vehicle->transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="manual" {{ old('transmission', $vehicle->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="fuel_type" class="block text-sm font-medium text-gray-700">Fuel Type</label>
                        <select name="fuel_type" id="fuel_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="gasoline" {{ old('fuel_type', $vehicle->fuel_type) == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                            <option value="diesel" {{ old('fuel_type', $vehicle->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="electric" {{ old('fuel_type', $vehicle->fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                            <option value="hybrid" {{ old('fuel_type', $vehicle->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="seats" class="block text-sm font-medium text-gray-700">Number of Seats</label>
                        <input type="number" name="seats" id="seats" value="{{ old('seats', $vehicle->seats) }}" min="1" max="50" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <div>
                        <label for="price_per_day" class="block text-sm font-medium text-gray-700">Price per Day (€)</label>
                        <input type="number" name="price_per_day" id="price_per_day" value="{{ old('price_per_day', $vehicle->price_per_day) }}" min="0" step="0.01" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
            
            <!-- Status -->
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Vehicle Status</h3>
                <div class="flex space-x-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                               {{ old('is_active', $vehicle->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Active (visible on the platform)
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_available" id="is_available" value="1" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                               {{ old('is_available', $vehicle->is_available) ? 'checked' : '' }}>
                        <label for="is_available" class="ml-2 block text-sm text-gray-700">
                            Available for booking
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $vehicle->description) }}</textarea>
            </div>
            
            <!-- Features -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @php
                        $features = [
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
                        $vehicleFeatures = old('features', $vehicle->features) ?? [];
                    @endphp
                    
                    @foreach($features as $key => $label)
                        <div class="flex items-center">
                            <input type="checkbox" name="features[]" id="feature_{{ $key }}" value="{{ $key }}" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                   {{ is_array($vehicleFeatures) && in_array($key, $vehicleFeatures) ? 'checked' : '' }}>
                            <label for="feature_{{ $key }}" class="ml-2 block text-sm text-gray-700">
                                {{ $label }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Current Photos -->
            @if($vehicle->photos->count() > 0)
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Current Photos</h3>
                    <p class="text-xs text-gray-500 mb-2">Select photos to delete or set as primary.</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach($vehicle->photos as $photo)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="h-32 w-full object-cover rounded-md">
                                
                                <div class="absolute inset-0 flex flex-col justify-between p-2 bg-black bg-opacity-0 hover:bg-opacity-30 transition-opacity">
                                    <div class="flex justify-end">
                                        <input type="checkbox" name="photos_to_delete[]" value="{{ $photo->id }}" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="primary_photo_id" value="{{ $photo->id }}" id="primary_{{ $photo->id }}" 
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                               {{ $photo->is_primary ? 'checked' : '' }}>
                                        <label for="primary_{{ $photo->id }}" class="ml-2 text-xs text-white font-medium">
                                            Set as main
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Add New Photos -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Add New Photos</label>
                <p class="text-xs text-gray-500 mb-2">Upload up to {{ 5 - $vehicle->photos->count() }} more photos.</p>
                
                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="new_photos" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload photos</span>
                                <input id="new_photos" name="new_photos[]" type="file" class="sr-only" multiple accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                <div id="photo-preview" class="mt-2 grid grid-cols-5 gap-2"></div>
            </div>
            
            <div class="mt-6 flex items-center justify-end">
                <button type="button" onclick="window.location='{{ route('company.vehicles.index') }}'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                    Cancel
                </button>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Vehicle
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Photo preview functionality for new photos
    document.getElementById('new_photos').addEventListener('change', function(event) {
        const preview = document.getElementById('photo-preview');
        preview.innerHTML = '';
        
        if (this.files) {
            const maxNewPhotos = {{ 5 - $vehicle->photos->count() }};
            if (this.files.length > maxNewPhotos) {
                alert('You can only upload up to ' + maxNewPhotos + ' more photos.');
                this.value = '';
                return;
            }
            
            Array.from(this.files).forEach((file, index) => {
                if (!file.type.match('image.*')) {
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-w-1 aspect-h-1';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="object-cover rounded-md h-32 w-full" />
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-md">
                            New photo ${index + 1}
                        </div>
                    `;
                    preview.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    });
</script>
@endsection