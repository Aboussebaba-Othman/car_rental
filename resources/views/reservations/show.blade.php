<!-- filepath: c:\Users\Youcode\Gestion-de-Location-des-Voitures\resources\views\reservations\show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Réservation #{{ $reservation->id }}</h1>
                <p class="text-gray-600 mt-1">Créée le {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y à H:i') }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm 
                @if($reservation->status === 'confirmed') bg-green-100 text-green-800 
                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800 
                @elseif($reservation->status === 'payment_pending') bg-blue-100 text-blue-800
                @elseif($reservation->status === 'canceled') bg-red-100 text-red-800
                @elseif($reservation->status === 'completed') bg-gray-100 text-gray-800
                @elseif($reservation->status === 'paid') bg-green-100 text-green-800
                @endif">
                @if($reservation->status === 'confirmed') Confirmée
                @elseif($reservation->status === 'pending') En attente
                @elseif($reservation->status === 'payment_pending') Paiement en cours
                @elseif($reservation->status === 'canceled') Annulée
                @elseif($reservation->status === 'completed') Terminée
                @elseif($reservation->status === 'paid') Payée
                @else {{ $reservation->status }}
                @endif
            </span>
        </div>

        <div class="bg-white overflow-hidden shadow-md rounded-lg">
            <!-- Vehicle Details Section -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Détails du véhicule</h2>
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-1/3 mb-4 md:mb-0">
                        @if($reservation->vehicle->photos->count() > 0)
                            <!-- Photo Gallery -->
                            <div class="vehicle-gallery relative">
                                <div class="main-photo mb-2">
                                    @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                                    <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" 
                                        class="w-full rounded-lg object-cover h-48" id="main-vehicle-photo">
                                </div>
                                
                                @if($reservation->vehicle->photos->count() > 1)
                                    <div class="thumbnails flex space-x-2 overflow-x-auto pb-2">
                                        @foreach($reservation->vehicle->photos as $photo)
                                            <div class="thumbnail-container flex-shrink-0">
                                                <img src="{{ asset('storage/' . $photo->path) }}" 
                                                    alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" 
                                                    class="h-16 w-20 object-cover rounded cursor-pointer hover:opacity-75 transition 
                                                    {{ $photo->id == $primaryPhoto->id ? 'border-2 border-yellow-500' : 'opacity-70' }}"
                                                    onclick="changeMainPhoto('{{ asset('storage/' . $photo->path) }}', this)">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="w-full md:w-2/3 md:pl-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }} ({{ $reservation->vehicle->year }})</h3>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="text-gray-600 text-sm">Transmission:</span>
                                <p class="font-medium">
                                    @if($reservation->vehicle->transmission === 'automatic') 
                                        Automatique
                                    @elseif($reservation->vehicle->transmission === 'manual')
                                        Manuelle
                                    @else
                                        {{ ucfirst($reservation->vehicle->transmission) }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Carburant:</span>
                                <p class="font-medium">
                                    @if($reservation->vehicle->fuel_type === 'gasoline') 
                                        Essence
                                    @elseif($reservation->vehicle->fuel_type === 'diesel')
                                        Diesel
                                    @elseif($reservation->vehicle->fuel_type === 'electric')
                                        Électrique
                                    @elseif($reservation->vehicle->fuel_type === 'hybrid')
                                        Hybride
                                    @else
                                        {{ ucfirst($reservation->vehicle->fuel_type) }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Nombre de places:</span>
                                <p class="font-medium">{{ $reservation->vehicle->seats }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Immatriculation:</span>
                                <p class="font-medium">{{ $reservation->vehicle->license_plate }}</p>
                            </div>
                        </div>
                        
                        @if(is_array($reservation->vehicle->features) && count($reservation->vehicle->features) > 0)
                        <div class="mb-3">
                            <span class="text-gray-600 text-sm">Équipements:</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($reservation->vehicle->features as $feature)
                                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
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
                                            Régulateur
                                            @break
                                        @case('parking_sensors')
                                            Capteurs
                                            @break
                                        @case('backup_camera')
                                            Caméra
                                            @break
                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                    @endswitch
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Reservation Details Section -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Détails de la réservation</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-700 mb-3">Dates et lieux</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="mb-3">
                                <span class="text-gray-600 text-sm">Période de location:</span>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-500">
                                    ({{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) }} jours)
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <span class="text-gray-600 text-sm">Lieu de prise en charge:</span>
                                <p class="font-medium">{{ $reservation->pickup_location }}</p>
                            </div>
                            
                            <div>
                                <span class="text-gray-600 text-sm">Lieu de retour:</span>
                                <p class="font-medium">{{ $reservation->return_location }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-700 mb-3">Tarification</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Prix par jour:</span>
                                <span>{{ number_format($reservation->vehicle->price_per_day, 2) }} €</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Durée de location:</span>
                                <span>{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1 }} jours</span>
                            </div>
                            
                            @if($reservation->promotion)
                            <div class="flex justify-between items-center mb-2 text-green-600">
                                <span>Promotion ({{ $reservation->promotion->name }}):</span>
                                <span>-{{ $reservation->promotion->discount_percentage }}%</span>
                            </div>
                            @endif
                            
                            <div class="border-t border-gray-300 my-2 pt-2 flex justify-between items-center font-semibold">
                                <span>Total:</span>
                                <span>{{ number_format($reservation->total_price, 2) }} €</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Driver Information Display -->
                @if($reservation->driver_name || $reservation->license_number)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Informations du conducteur
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <span class="text-gray-600 text-sm">Conducteur principal:</span>
                                    <p class="font-medium">{{ $reservation->driver_name ?? 'Non spécifié' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 text-sm">Téléphone:</span>
                                    <p class="font-medium">{{ $reservation->driver_phone ?? 'Non spécifié' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 text-sm">Numéro de permis:</span>
                                    <p class="font-medium">{{ $reservation->license_number ?? 'Non spécifié' }}</p>
                                </div>
                                
                                @if($reservation->license_country)
                                <div>
                                    <span class="text-gray-600 text-sm">Pays d'émission:</span>
                                    <p class="font-medium">
                                        @switch($reservation->license_country)
                                            @case('FR') France @break
                                            @case('BE') Belgique @break
                                            @case('CH') Suisse @break
                                            @case('ES') Espagne @break
                                            @case('DE') Allemagne @break
                                            @case('IT') Italie @break
                                            @case('UK') Royaume-Uni @break
                                            @default {{ $reservation->license_country }} @break
                                        @endswitch
                                    </p>
                                </div>
                                @endif
                                
                                @if($reservation->license_expiry)
                                <div>
                                    <span class="text-gray-600 text-sm">Expiration du permis:</span>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->license_expiry)->format('d/m/Y') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($reservation->additional_driver_name)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-2">Conducteur additionnel</h4>
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <span class="text-gray-600 text-sm">Nom:</span>
                                    <p class="font-medium">{{ $reservation->additional_driver_name }}</p>
                                </div>
                                
                                @if($reservation->additional_driver_license)
                                <div>
                                    <span class="text-gray-600 text-sm">Numéro de permis:</span>
                                    <p class="font-medium">{{ $reservation->additional_driver_license }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                @if($reservation->notes)
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Notes</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p>{{ $reservation->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Payment Information Section -->
            @if($reservation->status !== 'canceled')
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Informations de paiement</h2>
                
                @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']) && $reservation->payment_method)
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-green-800">Paiement effectué</h3>
                                <p class="text-green-600">Votre paiement a été traité avec succès.</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Méthode de paiement:</p>
                                <p class="font-medium">
                                    @if($reservation->payment_method == 'paypal')
                                        PayPal
                                    @else
                                        {{ ucfirst($reservation->payment_method) }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date de paiement:</p>
                                <p class="font-medium">{{ $reservation->payment_date ? \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y à H:i') : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Montant payé:</p>
                                <p class="font-medium">{{ number_format($reservation->amount_paid ?? $reservation->total_price, 2) }} €</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Référence transaction:</p>
                                <p class="font-medium">{{ $reservation->transaction_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                
                @elseif(in_array($reservation->status, ['pending', 'payment_pending']))
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-yellow-800">Paiement en attente</h3>
                                <p class="text-yellow-600">Votre réservation nécessite un paiement pour être confirmée.</p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('reservations.payment', $reservation) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700">
                                Procéder au paiement
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            @endif
            
            <!-- Actions Section -->
            <div class="p-6 flex items-center justify-between">
                <div>
                    @if(in_array($reservation->status, ['pending', 'payment_pending']))
                        <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Annuler la réservation
                            </button>
                        </form>
                    @elseif($reservation->status === 'confirmed' || $reservation->status === 'paid')
                        <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                <path d="M8 11a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                            </svg>
                            Télécharger la facture
                        </a>
                    @endif
                </div>
                <a href="{{ route('reservations.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Retour à mes réservations
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function changeMainPhoto(src, thumbnail) {
        // Update main photo
        document.getElementById('main-vehicle-photo').src = src;
        
        // Update active thumbnail styling
        const thumbnails = document.querySelectorAll('.thumbnails img');
        thumbnails.forEach(thumb => {
            thumb.classList.remove('border-2', 'border-yellow-500');
            thumb.classList.add('opacity-70');
        });
        
        thumbnail.classList.remove('opacity-70');
        thumbnail.classList.add('border-2', 'border-yellow-500');
    }
</script>
@endsection