<!-- filepath: c:\Users\Youcode\Gestion-de-Location-des-Voitures\resources\views\reservations\create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Réserver un véhicule</h1>
            <p class="text-gray-600 mt-1">Complétez le formulaire pour réserver {{ $vehicle->brand }} {{ $vehicle->model }}</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Des erreurs sont survenues:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Vehicle details -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9">
                        @if($vehicle->photos->count() > 0)
                            @php $primaryPhoto = $vehicle->photos->firstWhere('is_primary', true) ?? $vehicle->photos->first(); @endphp
                            <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</h3>
                        <div class="text-yellow-500 font-bold text-lg mb-2">{{ number_format($vehicle->price_per_day, 2) }}€ / jour</div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="text-gray-600 text-sm">Transmission:</span>
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
                                <span class="text-gray-600 text-sm">Carburant:</span>
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
                                <span class="text-gray-600 text-sm">Places:</span>
                                <p class="font-medium">{{ $vehicle->seats }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Immatriculation:</span>
                                <p class="font-medium">{{ $vehicle->license_plate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reservation form -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-4 text-white">
                        <h2 class="text-xl font-bold">Détails de votre réservation</h2>
                        <p>Tous les champs marqués d'un * sont obligatoires</p>
                    </div>
                    
                    <form method="POST" action="{{ route('reservations.store') }}" class="p-6">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                        <div class="mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Date de début *</label>
                                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" 
                                        class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200" required>
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Date de fin *</label>
                                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" 
                                        class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-1">Lieu de prise en charge *</label>
                                    <input type="text" id="pickup_location" name="pickup_location" value="{{ old('pickup_location') }}" 
                                        placeholder="Adresse complète" 
                                        class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200" required>
                                </div>
                                <div>
                                    <label for="return_location" class="block text-sm font-medium text-gray-700 mb-1">Lieu de retour *</label>
                                    <input type="text" id="return_location" name="return_location" value="{{ old('return_location') }}" 
                                        placeholder="Adresse complète" 
                                        class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes additionnelles</label>
                            <textarea id="notes" name="notes" rows="3" 
                                placeholder="Instructions spéciales, besoins particuliers, etc." 
                                class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200">{{ old('notes') }}</textarea>
                        </div>

                        @if(isset($promotion))
                        <input type="hidden" name="promotion_id" value="{{ $promotion->id }}">
                        <div class="mb-6 bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium text-yellow-800">Promotion appliquée: {{ $promotion->name }}</span>
                            </div>
                            <div class="mt-2 text-yellow-700">
                                Réduction de {{ $promotion->discount_percentage }}% sur le prix total.
                            </div>
                        </div>
                        @endif

                        <!-- Price summary -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-800 mb-3">Récapitulatif du prix</h3>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Prix par jour:</span>
                                <span>{{ number_format($pricePerDay, 2) }}€</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Nombre de jours:</span>
                                <span>{{ $numberOfDays }}</span>
                            </div>
                            
                            @if(isset($promotion))
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Sous-total:</span>
                                <span>{{ number_format($pricePerDay * $numberOfDays, 2) }}€</span>
                            </div>
                            <div class="flex justify-between items-center mb-2 text-green-600">
                                <span>Promotion ({{ $promotion->discount_percentage }}%):</span>
                                <span>-{{ number_format(($pricePerDay * $numberOfDays) * ($promotion->discount_percentage / 100), 2) }}€</span>
                            </div>
                            @endif
                            
                            <div class="border-t border-gray-300 my-2 pt-2 flex justify-between items-center font-semibold">
                                <span>Total:</span>
                                <span class="text-xl">{{ number_format($totalPrice, 2) }}€</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Retour
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Continuer
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        // Ensure end date is always after start date
        startDateInput.addEventListener('change', function() {
            if (endDateInput.value && new Date(startDateInput.value) >= new Date(endDateInput.value)) {
                // Set end date to start date + 1 day
                const nextDay = new Date(startDateInput.value);
                nextDay.setDate(nextDay.getDate() + 1);
                endDateInput.valueAsDate = nextDay;
            }
        });
        
        endDateInput.addEventListener('change', function() {
            if (new Date(endDateInput.value) <= new Date(startDateInput.value)) {
                alert('La date de fin doit être postérieure à la date de début.');
                // Set end date to start date + 1 day
                const nextDay = new Date(startDateInput.value);
                nextDay.setDate(nextDay.getDate() + 1);
                endDateInput.valueAsDate = nextDay;
            }
        });

        // Set minimum dates to today
        const today = new Date();
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        startDateInput.min = today.toISOString().split('T')[0];
        endDateInput.min = tomorrow.toISOString().split('T')[0];
    });
</script>
@endsection