@extends('layouts.admin')

@section('content')
<div class="px-6 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.vehicles.index') }}" class="text-gray-600 hover:text-yellow-600 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste des véhicules
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Vehicle Images -->
                <div class="lg:col-span-1">
                    <div class="border rounded-lg overflow-hidden bg-gray-100 h-64">
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
                            <div class="flex items-center justify-center h-full">
                                <i class="fas fa-car text-6xl text-gray-300"></i>
                            </div>
                        @endif
                    </div>
                    
                    @if($vehicle->photos && $vehicle->photos->count() > 1)
                        <div class="mt-3 grid grid-cols-4 gap-2">
                            @foreach($vehicle->photos->take(4) as $photo)
                                <div class="h-16 w-full border rounded overflow-hidden">
                                    <img src="{{ Storage::url($photo->path) }}" alt="Photo supplémentaire" class="h-full w-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="mt-6 bg-gray-50 rounded-lg p-4 border">
                        <h3 class="text-md font-medium text-gray-800 mb-3">Disponibilité</h3>
                        
                        @if($vehicle->is_available && $vehicle->is_active)
                            <div class="flex items-center justify-between">
                                <span class="flex items-center">
                                    <span class="h-3 w-3 rounded-full bg-green-500 mr-2"></span>
                                    <span class="text-green-700 font-medium">Disponible</span>
                                </span>
                                <span class="text-sm text-gray-500">Prêt à être loué</span>
                            </div>
                        @elseif(!$vehicle->is_available)
                            <div class="flex items-center justify-between">
                                <span class="flex items-center">
                                    <span class="h-3 w-3 rounded-full bg-blue-500 mr-2"></span>
                                    <span class="text-blue-700 font-medium">Non disponible</span>
                                </span>
                                <span class="text-sm text-gray-500">Temporairement indisponible</span>
                            </div>
                        @elseif(!$vehicle->is_active)
                            <div class="flex items-center justify-between">
                                <span class="flex items-center">
                                    <span class="h-3 w-3 rounded-full bg-red-500 mr-2"></span>
                                    <span class="text-red-700 font-medium">Inactif</span>
                                </span>
                                <span class="text-sm text-gray-500">Véhicule inactif</span>
                            </div>
                        @endif
                        
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-600">Prix par jour:</span>
                            <span class="text-xl font-bold text-yellow-600">{{ number_format($vehicle->price_per_day, 2) }} €</span>
                        </div>
                    </div>
                </div>
                
                <!-- Vehicle Details -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-lg p-5 mb-6 border">
                        <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">Informations du véhicule</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
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
                            
                            <div>
                                <p class="text-sm text-gray-500">Places</p>
                                <p class="font-medium">{{ $vehicle->seats }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Carburant</p>
                                <p class="font-medium">
                                    @switch($vehicle->fuel_type)
                                        @case('gasoline')
                                            Essence
                                            @break
                                        @case('diesel')
                                            Diesel
                                            @break
                                        @case('electric')
                                            Électrique
                                            @break
                                        @case('hybrid')
                                            Hybride
                                            @break
                                        @default
                                            {{ $vehicle->fuel_type }}
                                    @endswitch
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Transmission</p>
                                <p class="font-medium">{{ $vehicle->transmission == 'automatic' ? 'Automatique' : 'Manuelle' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Entreprise</p>
                                <p class="font-medium">{{ $vehicle->company->company_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        @if($vehicle->description)
                            <div class="mt-6 pt-4 border-t">
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="mt-1 text-gray-700">{{ $vehicle->description }}</p>
                            </div>
                        @endif
                        
                        @if($vehicle->features)
                            <div class="mt-6 pt-4 border-t">
                                <p class="text-sm text-gray-500 mb-2">Caractéristiques</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($vehicle->features as $feature)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-md">
                                            {{ $feature }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Company Information -->
                    @if($vehicle->company)
                        <div class="bg-gray-50 rounded-lg p-5 mb-6 border">
                            <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-building mr-2 text-yellow-500"></i> 
                                Information sur l'entreprise
                            </h3>
                            
                            <div class="flex items-center mb-4">
                                <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                                    <span class="text-yellow-600 font-bold text-xl">{{ substr($vehicle->company->company_name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <h4 class="font-medium">{{ $vehicle->company->company_name }}</h4>
                                    <p class="text-gray-500 text-sm">{{ $vehicle->company->user->email }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                                @if($vehicle->company->user && $vehicle->company->user->phone)
                                    <div>
                                        <p class="text-sm text-gray-500">Téléphone</p>
                                        <p class="font-medium">{{ $vehicle->company->user->phone }}</p>
                                    </div>
                                @endif
                                
                                @if($vehicle->company->address)
                                    <div>
                                        <p class="text-sm text-gray-500">Adresse</p>
                                        <p class="font-medium">{{ $vehicle->company->address }}, {{ $vehicle->company->city }}</p>
                                    </div>
                                @endif
                                
                                <div>
                                    <p class="text-sm text-gray-500">Statut</p>
                                    <p class="font-medium">
                                        @if($vehicle->company->is_validated)
                                            <span class="text-green-600">Validée</span>
                                        @else
                                            <span class="text-red-600">En attente de validation</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Membre depuis</p>
                                    <p class="font-medium">{{ $vehicle->company->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('admin.companies.show', $vehicle->company->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                    Voir le profil complet <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Reservation History -->
                    <div class="bg-gray-50 rounded-lg p-5 border">
                        <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-history mr-2 text-yellow-500"></i> 
                            Historique des réservations
                        </h3>
                        
                        @if($vehicle->reservations && $vehicle->reservations->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($vehicle->reservations->sortByDesc('created_at') as $reservation)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    #{{ $reservation->id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                                            <span class="text-xs font-medium text-yellow-700">
                                                                {{ $reservation->user ? substr($reservation->user->first_name ?? '', 0, 1) . substr($reservation->user->last_name ?? '', 0, 1) : 'N/A' }}
                                                            </span>
                                                        </div>
                                                        <div class="ml-3">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $reservation->user ? ($reservation->user->first_name ?? '') . ' ' . ($reservation->user->last_name ?? '') : 'Utilisateur inconnu' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - 
                                                    {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @switch($reservation->status)
                                                        @case('pending')
                                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                En attente
                                                            </span>
                                                            @break
                                                        @case('confirmed')
                                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                Confirmée
                                                            </span>
                                                            @break
                                                        @case('cancelled')
                                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                Annulée
                                                            </span>
                                                            @break
                                                        @case('completed')
                                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                Terminée
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                {{ $reservation->status }}
                                                            </span>
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="py-8 text-center">
                                <i class="fas fa-calendar-times text-gray-300 text-5xl mb-3"></i>
                                <p class="text-gray-500">Aucune réservation trouvée pour ce véhicule.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
