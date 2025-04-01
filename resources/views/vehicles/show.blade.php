<!-- filepath: c:\Users\Youcode\Gestion-de-Location-des-Voitures\resources\views\vehicles\show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }}</h1>
                    <p class="text-gray-600 text-lg">Année {{ $vehicle->year }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Vehicle Details -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-md rounded-lg">
                    <!-- Photo Gallery -->
                    <div class="relative">
                        @if($vehicle->photos->count() > 0)
                            <div class="carousel">
                                <!-- Primary photo -->
                                @php $primaryPhoto = $vehicle->photos->firstWhere('is_primary', true) ?? $vehicle->photos->first(); @endphp
                                <div class="carousel-main h-96 bg-gray-200">
                                    <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-full object-cover">
                                </div>
                                
                                <!-- Thumbnails -->
                                @if($vehicle->photos->count() > 1)
                                <div class="grid grid-cols-5 gap-2 mt-2">
                                    @foreach($vehicle->photos as $photo)
                                    <div class="h-20 cursor-pointer {{ $photo->is_primary ? 'ring-2 ring-yellow-500' : '' }}">
                                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-full object-cover rounded">
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="h-96 flex items-center justify-center bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Price Badge -->
                        <div class="absolute top-0 right-0 bg-yellow-500 text-white px-4 py-2 m-4 rounded-lg font-bold text-xl">
                            @if(isset($promotion) && $promotion->is_active)
                                <span class="line-through text-yellow-200 mr-2">{{ number_format($vehicle->price_per_day, 2) }}€</span>
                                {{ number_format($vehicle->price_per_day * (1 - $promotion->discount_percentage / 100), 2) }}€/jour
                            @else
                                {{ number_format($vehicle->price_per_day, 2) }}€/jour
                            @endif
                        </div>
                    </div>
                    
                    <!-- Vehicle Specifications -->
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Détails du véhicule</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 mb-3">Caractéristiques principales</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Marque</p>
                                            <p class="font-medium">{{ $vehicle->brand }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Modèle</p>
                                            <p class="font-medium">{{ $vehicle->model }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Année</p>
                                            <p class="font-medium">{{ $vehicle->year }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Immatriculation</p>
                                            <p class="font-medium">{{ $vehicle->license_plate }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 mb-3">Spécifications techniques</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Transmission</p>
                                            <p class="font-medium">
                                                @if($vehicle->transmission === 'automatic') 
                                                    Automatique
                                                @elseif($vehicle->transmission === 'manual')
                                                    Manuelle
                                                @else
                                                    {{ ucfirst($vehicle->transmission) }}
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Carburant</p>
                                            <p class="font-medium">
                                                @if($vehicle->fuel_type === 'gasoline') 
                                                    Essence
                                                @elseif($vehicle->fuel_type === 'diesel')
                                                    Diesel
                                                @elseif($vehicle->fuel_type === 'electric')
                                                    Électrique
                                                @elseif($vehicle->fuel_type === 'hybrid')
                                                    Hybride
                                                @else
                                                    {{ ucfirst($vehicle->fuel_type) }}
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Nombre de places</p>
                                            <p class="font-medium">{{ $vehicle->seats }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(is_array($vehicle->features) && count($vehicle->features) > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Équipements</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($vehicle->features as $feature)
                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                    @switch($feature)
                                        @case('air_conditioning')
                                            Climatisation
                                            @break
                                        @case('gps')
                                            GPS
                                            @break
                                        @case('bluetooth')
                                            Bluetooth
                                            @break
                                        @case('usb')
                                            Port USB
                                            @break
                                        @case('heated_seats')
                                            Sièges chauffants
                                            @break
                                        @case('sunroof')
                                            Toit ouvrant
                                            @break
                                        @case('cruise_control')
                                            Régulateur de vitesse
                                            @break
                                        @case('parking_sensors')
                                            Capteurs de stationnement
                                            @break
                                        @case('backup_camera')
                                            Caméra de recul
                                            @break
                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                    @endswitch
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        @if($vehicle->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Description</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600">{{ $vehicle->description }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Reservation Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-md rounded-lg overflow-hidden sticky top-6">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-4">
                        <h2 class="text-xl font-bold text-white">Réservez ce véhicule</h2>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('reservations.create', $vehicle->id) }}" method="GET">
                            <div class="mb-4">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                <div class="relative">
                                    <input type="date" id="start_date" name="start_date" 
                                           value="{{ request('start_date', \Carbon\Carbon::now()->addDay()->format('Y-m-d')) }}" 
                                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" 
                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                <div class="relative">
                                    <input type="date" id="end_date" name="end_date" 
                                           value="{{ request('end_date', \Carbon\Carbon::now()->addDays(3)->format('Y-m-d')) }}" 
                                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" 
                                           min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            @if(isset($promotion) && $promotion->is_active)
                            <div class="mb-6 bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium text-yellow-800">Promotion: {{ $promotion->name }}</span>
                                </div>
                                <div class="mt-1 text-yellow-700">
                                    -{{ $promotion->discount_percentage }}% sur le prix de location.
                                </div>
                                <input type="hidden" name="promotion_id" value="{{ $promotion->id }}">
                            </div>
                            @endif
                            
                            <div class="mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-600">Prix par jour:</span>
                                        <span>{{ number_format($vehicle->price_per_day, 2) }}€</span>
                                    </div>
                                    @if(isset($promotion) && $promotion->is_active)
                                    <div class="flex justify-between items-center mb-2 text-green-600">
                                        <span>Réduction ({{ $promotion->discount_percentage }}%):</span>
                                        <span>-{{ number_format($vehicle->price_per_day * $promotion->discount_percentage / 100, 2) }}€</span>
                                    </div>
                                    <div class="border-t border-gray-300 my-2 pt-2 flex justify-between items-center font-semibold">
                                        <span>Prix après réduction:</span>
                                        <span>{{ number_format($vehicle->price_per_day * (1 - $promotion->discount_percentage / 100), 2) }}€</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            @auth
                            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                Réserver maintenant
                            </button>
                            @else
                            <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Connectez-vous pour réserver
                            </a>
                            @endauth
                        </form>
                    </div>
                </div>
                
                @if(isset($vehicle->company))
                <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="border-b border-gray-200">
                        <h3 class="text-lg font-medium p-4">À propos de l'entreprise</h3>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            @if(isset($vehicle->company->logo) && $vehicle->company->logo)
                                <img src="{{ asset('storage/' . $vehicle->company->logo) }}" alt="{{ $vehicle->company->name }}" class="h-12 w-12 rounded-full object-cover mr-4">
                            @else
                                <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                                    <span class="text-yellow-800 font-bold">{{ strtoupper(substr($vehicle->company->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-medium">{{ $vehicle->company->name }}</h4>
                                <p class="text-sm text-gray-500">Membre depuis {{ $vehicle->company->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                        @if($vehicle->company->description)
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($vehicle->company->description, 150) }}</p>
                        @endif
                        <div class="text-right">
                            <a href="#" class="text-yellow-500 hover:text-yellow-700 text-sm font-medium">Voir tous les véhicules de cette compagnie</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle photo gallery thumbnail clicks
    const thumbnails = document.querySelectorAll('.carousel .grid .cursor-pointer');
    const mainImage = document.querySelector('.carousel-main img');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Update main image
            mainImage.src = this.querySelector('img').src;
            
            // Update active thumbnail styling
            thumbnails.forEach(t => t.classList.remove('ring-2', 'ring-yellow-500'));
            this.classList.add('ring-2', 'ring-yellow-500');
        });
    });
    
    // Date validation for reservation form
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            const startDate = new Date(this.value);
            const endDate = new Date(endDateInput.value);
            
            if (endDate <= startDate) {
                const newEndDate = new Date(startDate);
                newEndDate.setDate(newEndDate.getDate() + 1);
                endDateInput.value = newEndDate.toISOString().split('T')[0];
            }
            
            endDateInput.min = new Date(startDate.getTime() + 86400000).toISOString().split('T')[0];
        });
    }
});
</script>
@endsection