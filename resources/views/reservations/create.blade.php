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
                    <div class="relative">
                        @if($vehicle->photos->count() > 0)
                            <div class="aspect-w-16 aspect-h-9">
                                <!-- Main Photo Display -->
                                <div id="mainPhotoContainer" class="w-full h-48 relative">
                                    @foreach($vehicle->photos as $index => $photo)
                                        <img 
                                            src="{{ asset('storage/' . $photo->path) }}" 
                                            alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                                            class="w-full h-48 object-cover absolute top-0 left-0 transition-opacity duration-300 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                                            id="vehiclePhoto-{{ $index }}"
                                            data-index="{{ $index }}">
                                    @endforeach

                                    <!-- Photo Controls -->
                                    @if($vehicle->photos->count() > 1)
                                        <button type="button" id="prevPhoto" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-1 rounded-r-md hover:bg-opacity-70">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button type="button" id="nextPhoto" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-1 rounded-l-md hover:bg-opacity-70">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Thumbnails Navigation -->
                            @if($vehicle->photos->count() > 1)
                                <div class="flex overflow-x-auto py-2 px-1 bg-gray-100">
                                    @foreach($vehicle->photos as $index => $photo)
                                        <div 
                                            class="w-14 h-14 flex-shrink-0 mx-1 cursor-pointer rounded-md overflow-hidden thumbnail-item {{ $index === 0 ? 'ring-2 ring-yellow-500' : '' }}"
                                            data-index="{{ $index }}">
                                            <img 
                                                src="{{ asset('storage/' . $photo->path) }}" 
                                                alt="Thumbnail" 
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
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
                        
                        <!-- Features/Amenities -->
                        @php
                            $features = is_array($vehicle->features) 
                                ? $vehicle->features 
                                : (is_string($vehicle->features) ? json_decode($vehicle->features, true) : []);
                        @endphp

                        @if(!empty($features))
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Équipements</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($features as $feature)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $feature }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Availability Calendar Preview -->
                <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                        <h3 class="font-bold">Disponibilité</h3>
                    </div>
                    <div class="p-4">
                        <div id="availability-calendar" class="text-center text-sm"></div>
                        <div class="mt-2 flex justify-center items-center gap-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                                <span>Disponible</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                                <span>Indisponible</span>
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
                    
                    <form method="POST" action="{{ route('reservations.store') }}" class="p-6" id="reservation-form">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        <input type="hidden" id="price_per_day" value="{{ $vehicle->price_per_day }}">
                        <input type="hidden" id="hidden_total_price" name="total_price" value="{{ $totalPrice }}">

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
                            
                            <!-- Date selection helper -->
                            <div class="mt-1 text-sm text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <span>Vous pouvez louer ce véhicule pour un minimum de 1 jour et un maximum de 30 jours.</span>
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
                            
                            <!-- Quick address buttons -->
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button type="button" id="same-address-btn" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 transition-colors">
                                    Même adresse pour le retour
                                </button>
                                <button type="button" id="home-address-btn" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 transition-colors">
                                    Utiliser mon adresse
                                </button>
                                <button type="button" id="agency-address-btn" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 transition-colors">
                                    À l'agence
                                </button>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes additionnelles</label>
                            <textarea id="notes" name="notes" rows="3" 
                                placeholder="Instructions spéciales, besoins particuliers, etc." 
                                class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Promotion selection -->
                        @if(isset($availablePromotions) && count($availablePromotions) > 0)
                        <div class="mb-6">
                            <label for="promotion_id" class="block text-sm font-medium text-gray-700 mb-1">Promotion</label>
                            <select id="promotion_id" name="promotion_id" class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200">
                                <option value="">Aucune promotion</option>
                                @foreach($availablePromotions as $promo)
                                    <option value="{{ $promo->id }}" {{ isset($promotion) && $promotion->id == $promo->id ? 'selected' : '' }}>
                                        {{ $promo->name }} ({{ $promo->discount_percentage }}% de réduction)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @elseif(isset($promotion))
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
                                <span id="number_of_days">{{ $numberOfDays }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Sous-total:</span>
                                <span id="subtotal">{{ number_format($pricePerDay * $numberOfDays, 2) }}€</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2 text-green-600 discount-row" 
                                 style="{{ isset($promotion) ? '' : 'display: none;' }}">
                                <span>Promotion:</span>
                                <span id="discount">
                                    @if(isset($promotion))
                                        -{{ number_format(($pricePerDay * $numberOfDays) * ($promotion->discount_percentage / 100), 2) }}€ (-{{ $promotion->discount_percentage }}%)
                                    @else
                                        0.00€
                                    @endif
                                </span>
                            </div>
                            
                            <div class="border-t border-gray-300 my-2 pt-2 flex justify-between items-center font-semibold">
                                <span>Total:</span>
                                <span id="total_price" class="text-xl">{{ number_format($totalPrice, 2) }}€</span>
                            </div>
                        </div>
                        
                        <!-- Terms and conditions -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" class="h-4 w-4 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded" required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">J'accepte les <a href="#" class="text-yellow-500 hover:text-yellow-600">conditions générales</a></label>
                                    <p class="text-gray-500">En cochant cette case, vous acceptez les conditions de location et notre politique de confidentialité.</p>
                                </div>
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
                                Continuer vers le paiement
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

<script>
    /**
 * Calculateur de prix en temps réel pour les réservations
 */
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du formulaire
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const pricePerDay = parseFloat(document.getElementById('price_per_day').value || 0);
    const promotionElement = document.getElementById('promotion_id');
    const hiddenTotalPriceInput = document.getElementById('hidden_total_price');
    
    // Éléments d'affichage
    const numberOfDaysElement = document.getElementById('number_of_days');
    const subtotalElement = document.getElementById('subtotal');
    const discountElement = document.getElementById('discount');
    const totalPriceElement = document.getElementById('total_price');
    
    // Données des promotions
    const promotions = window.promotionsData || {};
    
    // Boutons d'adresse
    const pickupLocationInput = document.getElementById('pickup_location');
    const returnLocationInput = document.getElementById('return_location');
    const sameAddressBtn = document.getElementById('same-address-btn');
    const homeAddressBtn = document.getElementById('home-address-btn');
    const agencyAddressBtn = document.getElementById('agency-address-btn');
    const agencyAddress = "123 Rue de l'Agence, 75001 Paris";
    
    /**
     * Calcule le prix de la réservation et met à jour l'affichage
     */
    function calculatePrice() {
        if (!startDateInput || !endDateInput || !pricePerDay) {
            return;
        }
        
        // Obtenir les dates avec le temps réglé à minuit pour un calcul précis
        let startDate = new Date(startDateInput.value);
        let endDate = new Date(endDateInput.value);
        
        // Si les dates sont invalides, sortir
        if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
            return;
        }
        
        // Normaliser à minuit UTC pour un calcul cohérent
        startDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
        endDate = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
        
        // Calculer le nombre de jours (au moins 1 jour)
        const diffTime = Math.abs(endDate - startDate);
        const numberOfDays = Math.max(Math.ceil(diffTime / (1000 * 60 * 60 * 24)), 1);
        
        // Calculer le sous-total
        const subtotal = parseFloat((pricePerDay * numberOfDays).toFixed(2));
        
        // Vérifier promotion
        let discount = 0;
        let discountText = '';
        let promotionApplied = false;
        
        if (promotionElement && promotionElement.value) {
            const promotionId = parseInt(promotionElement.value);
            if (promotions[promotionId]) {
                const discountPercentage = promotions[promotionId].discount_percentage;
                discount = parseFloat(((subtotal * discountPercentage) / 100).toFixed(2));
                discountText = `(-${discountPercentage}%)`;
                promotionApplied = true;
            }
        }
        
        // Calculer le total (minimum 0.01)
        const totalPrice = Math.max(parseFloat((subtotal - discount).toFixed(2)), 0.01);
        
        // Mettre à jour l'affichage avec effet d'animation
        if (numberOfDaysElement) {
            const currentDays = parseInt(numberOfDaysElement.textContent) || 0;
            if (currentDays !== numberOfDays) {
                numberOfDaysElement.classList.add('text-yellow-600');
                numberOfDaysElement.textContent = numberOfDays;
                setTimeout(() => numberOfDaysElement.classList.remove('text-yellow-600'), 500);
            }
        }
        
        if (subtotalElement) {
            subtotalElement.textContent = formatCurrency(subtotal);
        }
        
        if (discountElement) {
            discountElement.textContent = discount > 0 ? 
                `${formatCurrency(discount)} ${discountText}` : 
                '0,00€';
            
            // Afficher/masquer ligne de remise
            const discountRow = discountElement.closest('.discount-row');
            if (discountRow) {
                if (promotionApplied) {
                    discountRow.style.display = 'flex';
                    discountRow.style.opacity = '1';
                } else {
                    discountRow.style.opacity = '0';
                    setTimeout(() => discountRow.style.display = 'none', 300);
                }
            }
        }
        
        if (totalPriceElement) {
            const currentPrice = parseFloat(totalPriceElement.textContent.replace('€', '').replace(',', '.')) || 0;
            if (Math.abs(currentPrice - totalPrice) > 0.01) {
                totalPriceElement.classList.add('text-yellow-600');
                totalPriceElement.textContent = formatCurrency(totalPrice);
                setTimeout(() => totalPriceElement.classList.remove('text-yellow-600'), 500);
            }
        }
        
        // Mettre à jour champ caché
        if (hiddenTotalPriceInput) {
            hiddenTotalPriceInput.value = totalPrice.toFixed(2);
        }
    }
    
    /**
     * Formater un montant en devise
     */
    function formatCurrency(amount) {
        return amount.toFixed(2).replace('.', ',') + '€';
    }
    
    /**
     * S'assurer que la date de fin est après la date de début
     */
    function validateDates() {
        if (!startDateInput || !endDateInput) return;
        
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) return;
        
        // Normaliser les dates
        const startMidnight = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
        const endMidnight = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
        
        if (endMidnight <= startMidnight) {
            // Ajouter un jour à la date de début
            const nextDay = new Date(startMidnight);
            nextDay.setDate(nextDay.getDate() + 1);
            
            // Formatage YYYY-MM-DD
            const year = nextDay.getFullYear();
            const month = String(nextDay.getMonth() + 1).padStart(2, '0');
            const day = String(nextDay.getDate()).padStart(2, '0');
            
            endDateInput.value = `${year}-${month}-${day}`;
        }
        
        calculatePrice();
    }
    
    /**
     * Définir les dates minimales
     */
    function setMinDates() {
        if (!startDateInput || !endDateInput) return;
        
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const formatDate = (date) => {
            return date.toISOString().split('T')[0];
        };
        
        startDateInput.min = formatDate(today);
        endDateInput.min = formatDate(tomorrow);
    }
    
    // Configuration des écouteurs d'événements
    
    // Dates
    if (startDateInput) {
        ['change', 'input'].forEach(event => {
            startDateInput.addEventListener(event, validateDates);
        });
    }
    
    if (endDateInput) {
        ['change', 'input'].forEach(event => {
            endDateInput.addEventListener(event, validateDates);
        });
    }
    
    // Promotion
    if (promotionElement) {
        promotionElement.addEventListener('change', calculatePrice);
    }
    
    // Boutons d'adresse
    if (sameAddressBtn) {
        sameAddressBtn.addEventListener('click', function() {
            if (pickupLocationInput.value) {
                returnLocationInput.value = pickupLocationInput.value;
            }
        });
    }
    
    if (homeAddressBtn) {
        homeAddressBtn.addEventListener('click', function() {
            const userAddress = userAddressData || '';
            if (userAddress) {
                pickupLocationInput.value = userAddress;
                returnLocationInput.value = userAddress;
            } else {
                alert('Aucune adresse trouvée dans votre profil. Veuillez la saisir manuellement.');
            }
        });
    }
    
    if (agencyAddressBtn) {
        agencyAddressBtn.addEventListener('click', function() {
            pickupLocationInput.value = agencyAddress;
            returnLocationInput.value = agencyAddress;
        });
    }
    
    // Galerie photos
    setupPhotoGallery();
    
    // Initialiser
    setMinDates();
    validateDates();
    
    // Recalculer à l'ouverture/focus de la page
    window.addEventListener('focus', calculatePrice);
    
    /**
     * Configure la galerie de photos
     */
    function setupPhotoGallery() {
        const photoCount = document.querySelectorAll('#mainPhotoContainer img').length;
        if (photoCount <= 1) return;
        
        let currentPhotoIndex = 0;
        const photoElements = document.querySelectorAll('#mainPhotoContainer img');
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');
        const prevButton = document.getElementById('prevPhoto');
        const nextButton = document.getElementById('nextPhoto');
        
        function showPhoto(index) {
            // Masquer toutes les photos
            photoElements.forEach(photo => {
                photo.classList.remove('opacity-100');
                photo.classList.add('opacity-0');
            });
            
            // Afficher la photo sélectionnée
            photoElements[index].classList.remove('opacity-0');
            photoElements[index].classList.add('opacity-100');
            
            // Mettre à jour les vignettes
            thumbnailItems.forEach(thumb => {
                thumb.classList.remove('ring-2', 'ring-yellow-500');
            });
            thumbnailItems[index].classList.add('ring-2', 'ring-yellow-500');
            
            currentPhotoIndex = index;
        }
        
        if (nextButton) {
            nextButton.addEventListener('click', function() {
                const newIndex = (currentPhotoIndex + 1) % photoCount;
                showPhoto(newIndex);
            });
        }
        
        if (prevButton) {
            prevButton.addEventListener('click', function() {
                const newIndex = (currentPhotoIndex - 1 + photoCount) % photoCount;
                showPhoto(newIndex);
            });
        }
        
        thumbnailItems.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                showPhoto(index);
            });
        });
        
        // Rotation automatique des photos
        setInterval(function() {
            const newIndex = (currentPhotoIndex + 1) % photoCount;
            showPhoto(newIndex);
        }, 5000);
    }
    
    // Ajouter du CSS pour les effets de transition
    const style = document.createElement('style');
    style.textContent = `
        #number_of_days, #total_price {
            transition: color 0.3s ease;
        }
        .discount-row {
            transition: opacity 0.3s ease;
        }
        .text-yellow-600 {
            color: #d97706;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection
