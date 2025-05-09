@extends('layouts.company')

@section('title', ' Créer la promotion')
@section('header', ' Créer la promotion ')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <!-- Header with breadcrumb -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Créer une nouvelle promotion</h2>
                <p class="mt-1 text-sm text-gray-600">Attirez plus de clients avec une offre spéciale sur votre flotte</p>
            </div>
            <a href="{{ route('company.promotions.index') }}" class="mt-3 md:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Retour aux promotions
            </a>
        </div>

        <div class="h-1 w-full bg-gray-200 rounded-full mt-5">
            <div class="h-1 rounded-full bg-indigo-600 transition-all duration-300" style="width: 33.33%"></div>
        </div>
    </div>

    <!-- Info box -->
    <div class="mb-8 bg-gradient-to-r from-amber-50 to-amber-100 border-l-4 border-amber-500 rounded-md overflow-hidden shadow-sm">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 text-amber-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-base font-medium text-amber-800">À savoir avant de créer une promotion</h3>
                    <div class="mt-2 text-sm text-amber-700">
                        <p class="leading-relaxed">
                            Un véhicule ne peut être inclus que dans une seule promotion active à la fois. 
                            Si vous ne sélectionnez aucun véhicule, la promotion s'appliquera à <strong>toute votre flotte</strong>, 
                            mais vous ne pourrez pas avoir d'autres promotions actives en même temps.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-6 md:px-8">
            <h3 class="text-lg font-medium text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Informations de la promotion
            </h3>
        </div>

        <!-- Form Content -->
        <div class="p-6 md:p-8">
            <form action="{{ route('company.promotions.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Error display -->
                @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-md overflow-hidden animate-pulse">
                    <div class="p-4 flex items-start">
                        <div class="flex-shrink-0 text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</p>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Basic Information -->
                <div class="space-y-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-100 rounded-full p-1 mr-3">
                            <div class="bg-indigo-600 rounded-full w-6 h-6 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">1</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Informations de base</h3>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nom de la promotion
                            </label>
                            <div class="mt-1 relative">
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="ex: Promotion d'été"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md transition-all px-3 py-2 border @error('name') border-red-500 @enderror"
                                />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Choisissez un nom accrocheur qui décrit bien la promotion
                            </p>
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <div class="mt-1">
                                <textarea
                                    id="description"
                                    name="description"
                                    placeholder="Décrivez les avantages de cette promotion..."
                                    rows="3"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md transition-all px-3 py-2 border"
                                >{{ old('description') }}</textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                <span id="char-count" class="text-indigo-600">0</span>/500 caractères
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Dates and Discount -->
                <div class="space-y-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-100 rounded-full p-1 mr-3">
                            <div class="bg-indigo-600 rounded-full w-6 h-6 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">2</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Période & Remise</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">
                                Date de début
                            </label>
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input
                                    type="date"
                                    id="start_date"
                                    name="start_date"
                                    value="{{ old('start_date', date('Y-m-d')) }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md transition-all px-3 py-2 border @error('start_date') border-red-500 @enderror"
                                />
                            </div>
                            <p class="mt-1 text-xs text-gray-500">La promotion commencera à minuit à cette date</p>
                            @error('start_date')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">
                                Date de fin
                            </label>
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input
                                    type="date"
                                    id="end_date"
                                    name="end_date"
                                    value="{{ old('end_date', date('Y-m-d', strtotime('+7 days'))) }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md transition-all px-3 py-2 border @error('end_date') border-red-500 @enderror"
                                />
                            </div>
                            <p class="mt-1 text-xs text-gray-500">La promotion se terminera à 23h59 à cette date</p>
                            @error('end_date')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="discount_percentage" class="block text-sm font-medium text-gray-700">
                            Pourcentage de remise (%)
                        </label>
                        <div class="mt-1">
                            <input
                                type="range"
                                id="discount_range"
                                min="1"
                                max="100"
                                value="{{ old('discount_percentage', 15) }}"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                            />
                            <div class="mt-2 relative">
                                <input
                                    type="number"
                                    id="discount_percentage"
                                    name="discount_percentage"
                                    value="{{ old('discount_percentage', 15) }}"
                                    min="1"
                                    max="100"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md transition-all px-3 py-2 border"
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                    <span class="text-gray-500 sm:text-sm px-3">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <p class="text-xs text-gray-500">Remise appliquée sur le prix de location</p>
                            <span id="discount-display" class="flex items-center text-xl font-medium text-indigo-700">
                                -{{ old('discount_percentage', 15) }}%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Vehicles Selection -->
                <div class="space-y-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-100 rounded-full p-1 mr-3">
                            <div class="bg-indigo-600 rounded-full w-6 h-6 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">3</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Sélection des véhicules</h3>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0 text-indigo-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-700">
                                    Sélectionnez les véhicules auxquels cette promotion s'appliquera.
                                    <span class="font-medium"> Si vous ne sélectionnez aucun véhicule, la promotion s'appliquera à toute votre flotte.</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2 relative">
                            <input
                                type="text"
                                id="vehicle_search"
                                placeholder="Rechercher un véhicule..."
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md px-3 py-2 border"
                            />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <div>
                            <select 
                                id="vehicle_filter" 
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md px-3 py-2 border"
                            >
                                <option value="all">Tous les types</option>
                                <option value="automatic">Automatique</option>
                                <option value="manual">Manuelle</option>
                                <option value="gasoline">Essence</option>
                                <option value="diesel">Diesel</option>
                                <option value="electric">Électrique</option>
                                <option value="hybrid">Hybride</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-600">
                            <span id="selected-count">0</span> véhicule(s) sélectionné(s)
                        </p>
                        <div>
                            <button 
                                type="button" 
                                id="select-all"
                                class="text-sm text-indigo-600 hover:text-indigo-900 font-medium"
                            >
                                Tout sélectionner
                            </button>
                            <span class="mx-2 text-gray-300">|</span>
                            <button 
                                type="button" 
                                id="deselect-all"
                                class="text-sm text-indigo-600 hover:text-indigo-900 font-medium"
                            >
                                Tout désélectionner
                            </button>
                        </div>
                    </div>

                    <div class="max-h-96 overflow-y-auto pr-2 vehicles-container">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse ($vehicles as $vehicle)
                                <div 
                                    class="border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200 overflow-hidden hover:border-indigo-300 vehicle-card"
                                    data-id="{{ $vehicle->id }}"
                                    data-brand="{{ strtolower($vehicle->brand) }}"
                                    data-model="{{ strtolower($vehicle->model) }}"
                                    data-transmission="{{ $vehicle->transmission }}"
                                    data-fuel="{{ $vehicle->fuel_type }}"
                                >
                                    <div class="relative h-32 bg-gray-200">
                                       
                                        <img src="{{ 
                                            $vehicle->photos && $vehicle->photos->isNotEmpty() 
                                                ? asset('storage/' . ($vehicle->photos->where('is_primary', true)->first()?->path ?? $vehicle->photos->first()->path))
                                                : asset('images/default-vehicle.jpg') 
                                        }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="h-full w-full object-cover">
                                            
                                        <div class="absolute top-3 right-3">
                                            <div class="rounded-full bg-white p-1 shadow-sm">
                                                <input
                                                    type="checkbox"
                                                    id="vehicle_{{ $vehicle->id }}"
                                                    name="applicable_vehicles[]"
                                                    value="{{ $vehicle->id }}"
                                                    class="vehicle-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-all"
                                                    {{ in_array($vehicle->id, old('applicable_vehicles', [])) ? 'checked' : '' }}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <label 
                                            for="vehicle_{{ $vehicle->id }}"
                                            class="block text-sm font-medium text-gray-700 cursor-pointer"
                                        >
                                            {{ $vehicle->brand }} {{ $vehicle->model }}
                                        </label>
                                        <div class="mt-1 flex items-center justify-between">
                                            <div class="flex items-center space-x-2 text-xs text-gray-500">
                                                <span>{{ $vehicle->year }}</span>
                                                <span>&bull;</span>
                                                <span>{{ $vehicle->transmission === 'automatic' ? 'Automatique' : 'Manuelle' }}</span>
                                                <span>&bull;</span>
                                                <span>
                                                    @if ($vehicle->fuel_type === 'gasoline')
                                                        Essence
                                                    @elseif ($vehicle->fuel_type === 'diesel')
                                                        Diesel
                                                    @elseif ($vehicle->fuel_type === 'electric')
                                                        Électrique
                                                    @else
                                                        Hybride
                                                    @endif
                                                </span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ number_format($vehicle->price_per_day, 2) }} €
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-3 bg-white rounded-lg p-8 text-center border border-gray-200">
                                    <div class="mx-auto h-12 w-12 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun véhicule disponible</h3>
                                    <p class="mt-1 text-sm text-gray-500">Vous devez d'abord ajouter des véhicules à votre flotte.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Ajouter un véhicule
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="pt-5 border-t border-gray-200 flex items-center justify-between">
                        <a 
                            href="{{ route('company.promotions.index') }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150"
                        >
                            Annuler
                        </a>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Créer la promotion
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .vehicles-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .vehicles-container::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        border-radius: 9999px;
    }
    
    .vehicles-container::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 9999px;
    }
    
    .vehicles-container::-webkit-scrollbar-thumb:hover {
        background-color: #9ca3af;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for description
        const descriptionInput = document.getElementById('description');
        const charCount = document.getElementById('char-count');
        
        function updateCharCount() {
            const count = descriptionInput.value.length;
            charCount.textContent = count;
            
            if (count > 500) {
                charCount.classList.add('text-red-600');
                charCount.classList.remove('text-amber-600', 'text-indigo-600');
            } else if (count > 400) {
                charCount.classList.add('text-amber-600');
                charCount.classList.remove('text-red-600', 'text-indigo-600');
            } else {
                charCount.classList.add('text-indigo-600');
                charCount.classList.remove('text-amber-600', 'text-red-600');
            }
        }
        
        descriptionInput.addEventListener('input', updateCharCount);
        updateCharCount(); // Initialize on page load
        
        // Discount range and input sync
        const discountRange = document.getElementById('discount_range');
        const discountInput = document.getElementById('discount_percentage');
        const discountDisplay = document.getElementById('discount-display');
        
        function updateDiscount(value) {
            const numValue = parseInt(value);
            const validValue = Math.min(Math.max(numValue, 1), 100);
            
            discountRange.value = validValue;
            discountInput.value = validValue;
            discountDisplay.textContent = `-${validValue}%`;
        }
        
        discountRange.addEventListener('input', function() {
            updateDiscount(this.value);
        });
        
        discountInput.addEventListener('input', function() {
            updateDiscount(this.value);
        });
        
        // Initialize discount display
        updateDiscount(discountInput.value);
        
        // Vehicle search and filter
        const vehicleSearch = document.getElementById('vehicle_search');
        const vehicleFilter = document.getElementById('vehicle_filter');
        const vehicleCards = document.querySelectorAll('.vehicle-card');
        const selectedCount = document.getElementById('selected-count');
        const selectAllButton = document.getElementById('select-all');
        const deselectAllButton = document.getElementById('deselect-all');
        
        function filterVehicles() {
            const searchTerm = vehicleSearch.value.toLowerCase();
            const filterValue = vehicleFilter.value.toLowerCase();
            
            vehicleCards.forEach(card => {
                const brand = card.dataset.brand;
                const model = card.dataset.model;
                const transmission = card.dataset.transmission;
                const fuel = card.dataset.fuel;
                
                const matchesSearch = (brand.includes(searchTerm) || model.includes(searchTerm));
                const matchesFilter = (filterValue === 'all' || transmission === filterValue || fuel === filterValue);
                
                if (matchesSearch && matchesFilter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        vehicleSearch.addEventListener('input', filterVehicles);
        vehicleFilter.addEventListener('change', filterVehicles);
        
        // Vehicle selection
        const vehicleCheckboxes = document.querySelectorAll('.vehicle-checkbox');
        
        function updateSelectedCount() {
            const checkedCount = document.querySelectorAll('.vehicle-checkbox:checked').length;
            selectedCount.textContent = checkedCount;
        }
        
        vehicleCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
            
            // Make the whole card clickable
            const card = checkbox.closest('.vehicle-card');
            if (card) {
                card.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = this.querySelector('input[type="checkbox"]');
                        checkbox.checked = !checkbox.checked;
                        
                        // Trigger change event
                        const event = new Event('change');
                        checkbox.dispatchEvent(event);
                    }
                });
            }
        });
        
        // Select/deselect all
        selectAllButton.addEventListener('click', function() {
            vehicleCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            updateSelectedCount();
        });
        
        deselectAllButton.addEventListener('click', function() {
            vehicleCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectedCount();
        });
        
        // Initialize selected count
        updateSelectedCount();
    });
</script>
@endpush
@endsection

