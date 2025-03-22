@extends('layouts.company')

@section('title', 'Manage Vehicles')
@section('header', 'Manage Vehicles')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Your Vehicle Fleet</h2>
        <a href="{{ route('company.vehicles.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add New Vehicle
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

@if($vehicles->count() > 0)
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vehicle
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Details
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($vehicle->photos->where('is_primary', true)->first())
                                            <img class="h-10 w-10 rounded-md object-cover" 
                                                 src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path) }}" 
                                                 alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                                        @else
                                            <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $vehicle->brand }} {{ $vehicle->model }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $vehicle->year }} · License: {{ $vehicle->license_plate }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ ucfirst($vehicle->transmission) }} · {{ ucfirst($vehicle->fuel_type) }}</div>
                                <div class="text-sm text-gray-500">{{ $vehicle->seats }} seats</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($vehicle->price_per_day, 2) }} €/day</div>
                                <div class="text-xs text-gray-500">
                                    @if($vehicle->reservations_count ?? 0)
                                        {{ $vehicle->reservations_count }} bookings
                                    @else
                                        No bookings yet
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $vehicle->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $vehicle->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('company.vehicles.show', $vehicle) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View
                                    </a>
                                    <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="text-green-600 hover:text-green-900">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('company.vehicles.destroy', $vehicle) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                <div class="flex space-x-2 mt-2">
                                    <form method="POST" action="{{ route('company.vehicles.toggle-active', $vehicle) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-gray-900">
                                            {{ $vehicle->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('company.vehicles.toggle-availability', $vehicle) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-gray-900">
                                            {{ $vehicle->is_available ? 'Mark Unavailable' : 'Mark Available' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t">
            {{ $vehicles->links() }}
        </div>
    </div>
@else
    <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No vehicles added yet</h3>
        <p class="mt-1 text-sm text-gray-500">Start by adding your first vehicle to your fleet.</p>
        <div class="mt-6">
            <a href="{{ route('company.vehicles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add Vehicle
            </a>
        </div>
    </div>
@endif
@endsection