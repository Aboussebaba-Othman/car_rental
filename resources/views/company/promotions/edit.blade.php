@extends('layouts.company')

@section('title', 'Edit Promotion')
@section('header', 'Edit Promotion')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Edit Promotion: {{ $promotion->name }}</h2>
            <a href="{{ route('company.promotions.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                Back to Promotions
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
        <form method="POST" action="{{ route('company.promotions.update', $promotion) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Promotion Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $promotion->name) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <div>
                        <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Discount Percentage (%)</label>
                        <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $promotion->discount_percentage) }}" min="1" max="100" 
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                               {{ $promotion->reservations_count > 0 ? 'readonly' : '' }}>
                        @if($promotion->reservations_count > 0)
                            <p class="mt-1 text-xs text-red-500">Cannot change discount percentage for promotions already used in reservations.</p>
                        @else
                            <p class="mt-1 text-xs text-gray-500">Enter a value between 1 and 100</p>
                        @endif
                    </div>
                </div>
                
                <!-- Date Information -->
                <div class="space-y-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
            
            <!-- Status -->
            <div class="mt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                           {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Active (visible and applicable to reservations)
                    </label>
                </div>
            </div>
            
            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $promotion->description) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Describe your promotion and any special conditions</p>
            </div>
            
            <!-- Applicable Vehicles -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Apply to Vehicles</label>
                <p class="mt-1 text-xs text-gray-500 mb-2">Leave unchecked to apply to all vehicles in your fleet</p>
                
                @if($vehicles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                        @php
                            $applicableVehicles = old('applicable_vehicles', $promotion->applicable_vehicles) ?? [];
                        @endphp
                        
                        @foreach($vehicles as $vehicle)
                            <div class="flex items-start space-x-3 p-3 border border-gray-200 rounded-md">
                                <div class="flex-shrink-0 pt-0.5">
                                    <input type="checkbox" name="applicable_vehicles[]" id="vehicle_{{ $vehicle->id }}" value="{{ $vehicle->id }}" 
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                           {{ in_array($vehicle->id, $applicableVehicles) ? 'checked' : '' }}>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label for="vehicle_{{ $vehicle->id }}" class="text-sm font-medium text-gray-700">
                                        {{ $vehicle->brand }} {{ $vehicle->model }}
                                    </label>
                                    <p class="text-xs text-gray-500">{{ $vehicle->year }} · {{ number_format($vehicle->price_per_day, 2) }} €/day</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-gray-50 rounded-md text-center">
                        <p class="text-gray-500">No vehicles in your fleet yet. Add vehicles first to apply specific promotions.</p>
                    </div>
                @endif
            </div>
            
            <div class="mt-6 flex items-center justify-end">
                <button type="button" onclick="window.location='{{ route('company.promotions.index') }}'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                    Cancel
                </button>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Promotion
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Ensure end date is after start date
    document.getElementById('start_date').addEventListener('change', function() {
        const startDate = this.value;
        const endDateInput = document.getElementById('end_date');
        
        if (startDate) {
            // Set minimum end date to be one day after start date
            const nextDay = new Date(startDate);
            nextDay.setDate(nextDay.getDate() + 1);
            
            // Format as YYYY-MM-DD
            const year = nextDay.getFullYear();
            const month = String(nextDay.getMonth() + 1).padStart(2, '0');
            const day = String(nextDay.getDate()).padStart(2, '0');
            
            endDateInput.min = `${year}-${month}-${day}`;
            
            // If current end date is before new minimum, update it
            if (endDateInput.value && new Date(endDateInput.value) < nextDay) {
                endDateInput.value = `${year}-${month}-${day}`;
            }
        }
    });
</script>
@endsection