@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Nos véhicules disponibles</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Découvrez notre sélection de véhicules et trouvez celui qui correspond parfaitement à vos besoins.
            </p>
        </div>

        <!-- Filters and Sorting -->
        <div class="mb-8 bg-white rounded-lg shadow p-4">
            <form action="{{ route('vehicles.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Brand Filter -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                    <select name="brand" id="brand" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                        <option value="">Toutes les marques</option>
                        @foreach($brands ?? [] as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Fuel Type Filter -->
                <div>
                    <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Carburant</label>
                    <select name="fuel_type" id="fuel_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                        <option value="">Tous types</option>
                        <option value="gasoline" {{ request('fuel_type') == 'gasoline' ? 'selected' : '' }}>Essence</option>
                        <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Électrique</option>
                        <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybride</option>
                    </select>
                </div>
                
                <!-- Price Range -->
                <div>
                    <label for="price_range" class="block text-sm font-medium text-gray-700 mb-1">Prix par jour</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="price_min" id="price_min" placeholder="Min €" 
                               value="{{ request('price_min') }}" min="0" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                        <input type="number" name="price_max" id="price_max" placeholder="Max €" 
                               value="{{ request('price_max') }}" min="0" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                    </div>
                </div>
                
                <!-- Sort Order -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                    <select name="sort" id="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    </select>
                </div>
                
                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Vehicles Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($vehicles as $vehicle)
            <!-- Vehicle Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg transform hover:-translate-y-1 relative">
                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="block relative h-48">
                    @if($vehicle->photos->count() > 0)
                        @php $primaryPhoto = $vehicle->photos->firstWhere('is_primary', true) ?? $vehicle->photos->first(); @endphp
                        <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-0 right-0 bg-yellow-500 text-white px-3 py-1 m-2 rounded-lg font-medium">
                        {{ number_format($vehicle->price_per_day, 2) }}€/jour
                    </div>
                </a>
                
                <div class="p-6">
                    <a href="{{ route('vehicles.show', $vehicle->id) }}" class="block">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                    </a>
                    
                    <div class="flex flex-wrap text-sm text-gray-600 mb-4">
                        <div class="flex items-center mr-4 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h2a1 1 0 001-1v-3a1 1 0 00-.2-.4l-3-4A1 1 0 0011 5H4a1 1 0 00-1 1z" />
                            </svg>
                            @switch($vehicle->fuel_type)
                                @case('gasoline') Essence @break
                                @case('diesel') Diesel @break
                                @case('electric') Électrique @break
                                @case('hybrid') Hybride @break
                                @default {{ ucfirst($vehicle->fuel_type) }} @break
                            @endswitch
                        </div>
                        <div class="flex items-center mr-4 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            {{ $vehicle->seats }} places
                        </div>
                        <div class="flex items-center mr-4 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            @switch($vehicle->transmission)
                                @case('automatic') Automatique @break
                                @case('manual') Manuelle @break
                                @default {{ ucfirst($vehicle->transmission) }} @break
                            @endswitch
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="flex-1 block py-2 px-4 text-center border border-yellow-500 rounded-lg text-yellow-500 font-medium hover:bg-yellow-500 hover:text-white transition duration-200">
                            Détails
                        </a>
                        <a href="{{ route('reservations.create', $vehicle->id) }}" class="flex-1 block py-2 px-4 text-center bg-yellow-500 rounded-lg text-white font-medium hover:bg-yellow-600 transition duration-200">
                            Réserver
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-10">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-gray-700 text-lg mb-2 font-medium">Aucun véhicule disponible</p>
                    <p class="text-gray-500 mb-4">Aucun véhicule ne correspond à vos critères de recherche.</p>
                    <a href="{{ route('vehicles.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Effacer les filtres
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($vehicles) && method_exists($vehicles, 'hasPages') && $vehicles->hasPages())
        <div class="mt-8">
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Affichage de 
                            <span class="font-medium">{{ $vehicles->firstItem() ?? 0 }}</span>
                            à
                            <span class="font-medium">{{ $vehicles->lastItem() ?? 0 }}</span>
                            sur
                            <span class="font-medium">{{ $vehicles->total() }}</span>
                            véhicules
                        </p>
                    </div>
                    <div>
                        {{ $vehicles->links() }}
                    </div>
                </div>
                
                <!-- Mobile pagination -->
                <div class="flex items-center justify-between w-full sm:hidden">
                    @if($vehicles->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Précédent
                        </span>
                    @else
                        <a href="{{ $vehicles->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Précédent
                        </a>
                    @endif
                    
                    <div class="text-sm text-gray-700">
                        <span class="font-medium">{{ $vehicles->currentPage() }}</span> sur <span class="font-medium">{{ $vehicles->lastPage() }}</span>
                    </div>
                    
                    @if($vehicles->hasMorePages())
                        <a href="{{ $vehicles->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Suivant
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Suivant
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
        
        <!-- Back to home or browse more -->
        <div class="text-center mt-10">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 font-medium mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
