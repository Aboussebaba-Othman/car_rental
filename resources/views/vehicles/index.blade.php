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
            <div class="hover-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 relative">
                <div class="relative h-56 vehicle-gallery">
                    @if($vehicle->photos->count() > 0)
                        <div class="gallery-container" data-index="0">
                            @foreach($vehicle->photos as $index => $photo)
                                <div class="gallery-slide">
                                    <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }} - Photo {{ $index + 1 }}" class="w-full h-56 object-cover">
                                </div>
                            @endforeach
                        </div>
                        
                        @if($vehicle->photos->count() > 1)
                            <button class="gallery-nav gallery-prev" onclick="moveGallery(this.parentNode, -1)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button class="gallery-nav gallery-next" onclick="moveGallery(this.parentNode, 1)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <div class="gallery-indicators">
                                @foreach($vehicle->photos as $index => $photo)
                                    <div class="gallery-indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                                @endforeach
                            </div>
                            
                            <div class="absolute top-0 right-0 bg-black bg-opacity-50 text-white text-xs px-2 py-1 m-2 rounded-lg">
                                <span class="current-photo">1</span>/<span>{{ $vehicle->photos->count() }}</span>
                            </div>
                        @endif
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-yellow-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute bottom-0 right-0 bg-yellow-500 text-white px-3 py-1 m-3 rounded-lg font-medium shadow-md">
                        {{ number_format($vehicle->price_per_day, 2) }}€/jour
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-xl font-bold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        @if(isset($vehicle->average_rating) && $vehicle->average_rating > 0)
                        <div class="flex items-center text-sm text-yellow-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-1">{{ number_format($vehicle->average_rating, 1) }}</span>
                        </div>
                        @endif
                    </div>
                    
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
                        
                        @if(is_array($vehicle->features) && count($vehicle->features) > 0)
                        <div class="w-full mt-2">
                            <div class="flex flex-wrap gap-2">
                                @foreach(array_slice($vehicle->features, 0, 3) as $feature)
                                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                    @switch($feature)
                                        @case('air_conditioning') Climatisation @break
                                        @case('gps') GPS @break
                                        @case('bluetooth') Bluetooth @break
                                        @case('usb') Port USB @break
                                        @case('heated_seats') Sièges chauffants @break
                                        @case('sunroof') Toit ouvrant @break
                                        @case('cruise_control') Régulateur @break
                                        @case('parking_sensors') Capteurs @break
                                        @case('backup_camera') Caméra @break
                                        @default {{ ucfirst(str_replace('_', ' ', $feature)) }} @break
                                    @endswitch
                                </span>
                                @endforeach
                                @if(count($vehicle->features) > 3)
                                <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                                    +{{ count($vehicle->features) - 3 }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
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

<!-- Add gallery functionality script -->
@push('scripts')
<script>
    function moveGallery(gallery, direction) {
        const container = gallery.querySelector('.gallery-container');
        const slides = gallery.querySelectorAll('.gallery-slide');
        const indicators = gallery.querySelectorAll('.gallery-indicator');
        const currentIndex = parseInt(container.dataset.index);
        const totalSlides = slides.length;
        
        let newIndex = currentIndex + direction;
        
        if (newIndex < 0) newIndex = totalSlides - 1;
        if (newIndex >= totalSlides) newIndex = 0;
        
        container.dataset.index = newIndex;
        container.style.transform = `translateX(-${newIndex * 100}%)`;
        
        // Update indicators
        indicators.forEach(indicator => {
            indicator.classList.remove('active');
        });
        indicators[newIndex].classList.add('active');
        
        // Update counter
        const counter = gallery.querySelector('.current-photo');
        if (counter) counter.textContent = newIndex + 1;
    }
    
    // Add click event to indicators
    document.querySelectorAll('.gallery-indicator').forEach(indicator => {
        indicator.addEventListener('click', function() {
            const gallery = this.closest('.vehicle-gallery');
            const container = gallery.querySelector('.gallery-container');
            const currentIndex = parseInt(container.dataset.index);
            const targetIndex = parseInt(this.dataset.index);
            
            moveGallery(gallery, targetIndex - currentIndex);
        });
    });
</script>
@endpush

<style>
    /* Vehicle gallery */
    .vehicle-gallery {
        position: relative;
        overflow: hidden;
        border-radius: 0.75rem 0.75rem 0 0;
    }
    
    .gallery-container {
        display: flex;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .gallery-slide {
        min-width: 100%;
    }
    
    .gallery-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        opacity: 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .vehicle-gallery:hover .gallery-nav {
        opacity: 1;
    }
    
    .gallery-nav:hover {
        background-color: rgba(255, 255, 255, 0.95);
        transform: translateY(-50%) scale(1.1);
    }
    
    .gallery-prev {
        left: 0.75rem;
    }
    
    .gallery-next {
        right: 0.75rem;
    }
    
    .gallery-indicators {
        position: absolute;
        bottom: 0.75rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 0.35rem;
        padding: 0.25rem 0.5rem;
        background-color: rgba(0, 0, 0, 0.3);
        border-radius: 1rem;
    }
    
    .gallery-indicator {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .gallery-indicator.active {
        background-color: white;
        transform: scale(1.2);
    }
    
    /* Card hover effects */
    .hover-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@include('layouts.footer')
@include('layouts.scripts')
@endsection
