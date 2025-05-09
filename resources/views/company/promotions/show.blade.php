@extends('layouts.company')

@section('title', $promotion->name)
@section('header', 'Promotion Details')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">{{ $promotion->name }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('company.promotions.edit', $promotion) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Edit Promotion
                </a>
                <a href="{{ route('company.promotions.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Back to Promotions
                </a>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Promotion Header Section -->
        <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">{{ $promotion->name }}</h3>
                    <p class="mt-1 opacity-80">{{ $promotion->description }}</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ $promotion->discount_percentage }}%</div>
                    <div class="text-sm">Discount</div>
                </div>
            </div>
        </div>
        
        <!-- Promotion Information Section -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Key Details -->
            <div class="space-y-4">
                <h4 class="text-lg font-medium text-gray-800 border-b pb-2">Promotion Details</h4>
                
                <!-- Status -->
                @php
                    $today = now()->startOfDay();
                    $startDate = \Carbon\Carbon::parse($promotion->start_date)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($promotion->end_date)->startOfDay();
                    
                    if(!$promotion->is_active) {
                        $statusClass = 'bg-gray-100 text-gray-800';
                        $statusText = 'Inactive';
                    } elseif($today->lt($startDate)) {
                        $statusClass = 'bg-blue-100 text-blue-800';
                        $statusText = 'Upcoming';
                    } elseif($today->lte($endDate)) {
                        $statusClass = 'bg-green-100 text-green-800';
                        $statusText = 'Active';
                    } else {
                        $statusClass = 'bg-red-100 text-red-800';
                        $statusText = 'Expired';
                    }
                @endphp
                
                <div class="flex items-center">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }} mr-2">
                        {{ $statusText }}
                    </span>
                    <span class="text-sm text-gray-500">
                        @if(!$promotion->is_active)
                            Manually deactivated
                        @elseif($today->lt($startDate))
                            Starts in {{ $today->diffInDays($startDate) }} days
                        @elseif($today->lte($endDate))
                            Ends in {{ $today->diffInDays($endDate) }} days
                        @else
                            Expired {{ $endDate->diffInDays($today) }} days ago
                        @endif
                    </span>
                </div>
                
                <!-- Date Range -->
                <div class="flex flex-col">
                    <div class="text-sm text-gray-500">Validity Period</div>
                    <div class="flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <div class="font-medium">
                                {{ $promotion->start_date->format('M d, Y') }} - {{ $promotion->end_date->format('M d, Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $promotion->start_date->diffInDays($promotion->end_date) + 1 }} days total
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Created Information -->
                <div class="flex flex-col">
                    <div class="text-sm text-gray-500">Created</div>
                    <div class="mt-1 font-medium">{{ $promotion->created_at->format('M d, Y') }}</div>
                </div>
                
                <!-- Usage Count -->
                <div class="flex flex-col">
                    <div class="text-sm text-gray-500">Usage Count</div>
                    <div class="mt-1 font-medium">{{ $promotion->reservations_count ?? 0 }} reservations</div>
                </div>
            </div>
            
            <!-- Applicable Vehicles -->
            <div class="md:col-span-2 space-y-4">
                <h4 class="text-lg font-medium text-gray-800 border-b pb-2">Applied To</h4>
                
                @if($promotion->applicable_vehicles)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $applicableVehicleIds = $promotion->applicable_vehicles;
                            $applicableVehicles = $promotion->company->vehicles->whereIn('id', $applicableVehicleIds);
                        @endphp
                        
                        @foreach($applicableVehicles as $vehicle)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-md overflow-hidden">
                                    @if($vehicle->photos->count() > 0)
                                        <img src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path ?? $vehicle->photos->first()->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h4>
                                        <p class="text-sm font-medium text-gray-900">{{ number_format($vehicle->price_per_day, 2) }} €/day</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $vehicle->year }} · {{ ucfirst($vehicle->transmission) }} · {{ ucfirst($vehicle->fuel_type) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-blue-50 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    This promotion applies to <span class="font-medium">all vehicles</span> in your fleet.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        @foreach($promotion->company->vehicles->take(4) as $vehicle)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-md overflow-hidden">
                                    @if($vehicle->photos->count() > 0)
                                        <img src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path ?? $vehicle->photos->first()->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h4>
                                        <p class="text-sm font-medium text-gray-900">{{ number_format($vehicle->price_per_day, 2) }} €/day</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $vehicle->year }} · {{ ucfirst($vehicle->transmission) }} · {{ ucfirst($vehicle->fuel_type) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($promotion->company->vehicles->count() > 4)
                        <div class="text-center mt-2">
                            <p class="text-sm text-gray-500">And {{ $promotion->company->vehicles->count() - 4 }} more vehicles</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        
        <!-- Recent Bookings with this Promotion -->
        @if($promotion->reservations->count() > 0)
            <div class="p-6 border-t border-gray-200">
                <h4 class="text-lg font-medium text-gray-800 mb-4">Recent Bookings with this Promotion</h4>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Booking ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Vehicle
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dates
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($promotion->reservations->take(5) as $reservation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $reservation->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->start_date->format('M d, Y') }} - {{ $reservation->end_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($reservation->total_price, 2) }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reservation->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($reservation->status == 'confirmed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmed
                                            </span>
                                        @elseif($reservation->status == 'completed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Completed
                                            </span>
                                        @elseif($reservation->status == 'canceled')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Canceled
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($promotion->reservations->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View All Bookings with this Promotion
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="p-6 border-t border-gray-200 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings yet</h3>
                <p class="mt-1 text-sm text-gray-500">This promotion hasn't been used in any bookings yet.</p>
            </div>
        @endif
        
        <!-- Actions Section -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
            <div>
                @if(!$promotion->reservations->count())
                    <form method="POST" action="{{ route('company.promotions.destroy', $promotion) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Delete Promotion
                        </button>
                    </form>
                @endif
            </div>
            
            <div>
                <form method="POST" action="{{ route('company.promotions.toggle-active', $promotion) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        @if($promotion->is_active)
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                            </svg>
                            Deactivate Promotion
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Activate Promotion
                        @endif
                    </button>
                </form>
                
                <a href="{{ route('company.promotions.edit', $promotion) }}" class="inline-flex ml-3 items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit Promotion
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    // Modal confirmation for deletion
    const deleteButtons = document.querySelectorAll('.delete-promotion');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            if (confirm('Êtes-vous sûr de vouloir supprimer cette promotion ? Cette action est irréversible.')) {
                form.submit();
            }
        });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection