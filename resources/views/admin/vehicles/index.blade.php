@extends('layouts.admin')

@section('content')
<div class="px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Véhicules disponibles</h1>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800 flex items-center">
                <i class="fas fa-filter text-yellow-500 mr-2"></i> Filtrer les véhicules
            </h3>
        </div>
        
        <form action="{{ route('admin.vehicles.index') }}" method="GET" class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Search Input -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            id="search"
                            value="{{ request('search') }}" 
                            placeholder="Marque, modèle, plaque..." 
                            class="block w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400"
                        >
                    </div>
                </div>
                
                <!-- Company Filter -->
                <div>
                    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-building text-gray-400"></i>
                        </div>
                        <select 
                            name="company_id" 
                            id="company_id" 
                            class="block w-full pl-10 pr-10 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400"
                        >
                            <option value="">Toutes les entreprises</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Availability Filter -->
                <div>
                    <label for="availability" class="block text-sm font-medium text-gray-700 mb-1">Disponibilité</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-circle-check text-gray-400"></i>
                        </div>
                        <select 
                            name="availability" 
                            id="availability" 
                            class="block w-full pl-10 pr-10 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400"
                        >
                            <option value="">Tous les statuts</option>
                            <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Disponibles</option>
                            <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Non disponibles</option>
                            <option value="inactive" {{ request('availability') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                        </select>
                        
                    </div>
                </div>
            </div>
            
            <!-- Filter Controls -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                <a 
                    href="{{ route('admin.vehicles.index') }}" 
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 inline-flex items-center transition-colors"
                >
                    <i class="fas fa-redo text-gray-500 mr-2"></i> Réinitialiser
                </a>
                
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md shadow-sm inline-flex items-center transition-colors"
                >
                    <i class="fas fa-search mr-2"></i> Rechercher
                </button>
            </div>
        </form>
    </div>

    <!-- Vehicles Grid -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($vehicles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($vehicles as $vehicle)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-gray-200 overflow-hidden">
                        <div class="h-48 bg-gray-100 relative overflow-hidden">
                            @php 
                                $hasImage = false;
                                $imagePath = '';
                                
                                // Check if vehicle has primary photo
                                if($vehicle->photos && $vehicle->photos->count() > 0) {
                                    $primaryPhoto = $vehicle->photos->where('is_primary', true)->first();
                                    if (!$primaryPhoto) {
                                        $primaryPhoto = $vehicle->photos->first();
                                    }
                                    
                                    if ($primaryPhoto) {
                                        $hasImage = true;
                                        $imagePath = $primaryPhoto->path;
                                    }
                                }
                            @endphp
                            
                            @if($hasImage)
                                <img src="{{ Storage::url($imagePath) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full bg-gray-200">
                                    <i class="fas fa-car text-5xl text-gray-400"></i>
                                </div>
                            @endif
                            
                            <div class="absolute top-2 right-2">
                                @if($vehicle->is_available && $vehicle->is_active)
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-md">Disponible</span>
                                @elseif(!$vehicle->is_available)
                                    <span class="px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-md">Non disponible</span>
                                @elseif(!$vehicle->is_active)
                                    <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-md">Inactif</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-4 border-b">
                            <h3 class="text-lg font-bold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                            <p class="text-gray-600 text-sm">{{ $vehicle->year }} · {{ $vehicle->fuel_type }}</p>
                            
                            <div class="mt-2 flex items-center">
                                <i class="fas fa-building text-gray-400 mr-1"></i>
                                <span class="text-sm text-gray-600">{{ $vehicle->company->company_name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-sm text-gray-500">Prix/jour</span>
                                    <p class="font-bold text-yellow-600">{{ number_format($vehicle->price_per_day, 2) }}€</p>
                                </div>
                                
                                <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1.5 px-3 rounded-md text-sm transition-colors flex items-center">
                                    <i class="fas fa-eye mr-1.5"></i> Détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $vehicles->appends(request()->query())->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <div class="inline-flex rounded-full bg-yellow-100 p-4 mb-4">
                    <div class="rounded-full bg-yellow-200 p-4">
                        <i class="fas fa-car text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Aucun véhicule trouvé</h3>
                <p class="text-gray-500 mb-4 max-w-md mx-auto">
                    Nous n'avons pas trouvé de véhicules correspondant à vos critères de recherche. Essayez d'ajuster les filtres.
                </p>
                <a href="{{ route('admin.vehicles.index') }}" class="text-yellow-500 hover:text-yellow-700 font-medium">
                    Réinitialiser les filtres
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
