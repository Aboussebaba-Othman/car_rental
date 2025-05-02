@extends('layouts.company')

@section('title', 'Edit Vehicle')
@section('header', 'Edit Vehicle')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6 bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 p-5 rounded-lg shadow-sm border border-indigo-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="flex flex-col">
                <div class="flex items-center mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full text-white flex items-center justify-center mr-3 shadow-md">
                        <i class="fas fa-car text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 flex items-center flex-wrap">
                            {{ $vehicle->brand }} {{ $vehicle->model }}
                            <span class="ml-3 px-3 py-1 bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-800 text-xs font-medium rounded-full shadow-sm">{{ $vehicle->year }}</span>
                            @if($vehicle->is_active)
                                <span class="ml-2 px-2 py-0.5 bg-gradient-to-r from-green-100 to-green-200 text-green-800 text-xs rounded-full shadow-sm">Actif</span>
                            @else
                                <span class="ml-2 px-2 py-0.5 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 text-xs rounded-full shadow-sm">Inactif</span>
                            @endif
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">
                            <i class="fas fa-tag text-indigo-500 mr-1"></i> {{ $vehicle->license_plate }} 
                            <i class="fas fa-gas-pump text-indigo-500 ml-3 mr-1"></i> {{ ucfirst(__($vehicle->fuel_type)) }}
                            <i class="fas fa-cog text-indigo-500 ml-3 mr-1"></i> {{ $vehicle->transmission === 'automatic' ? 'Automatique' : 'Manuelle' }}
                            <i class="fas fa-users text-indigo-500 ml-3 mr-1"></i> {{ $vehicle->seats }} places
                        </p>
                    </div>
                </div>
                <div class="flex items-center mt-2 text-sm text-gray-500 md:mt-0">
                    <span class="bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 rounded-full px-3 py-1 flex items-center shadow-sm">
                        <i class="fas fa-euro-sign mr-1 text-blue-500"></i> {{ number_format($vehicle->price_per_day, 2, ',', ' ') }} € par jour
                    </span>
                    @if($vehicle->reservations_count > 0)
                        <span class="ml-3 bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 rounded-full px-3 py-1 flex items-center shadow-sm">
                            <i class="fas fa-calendar-check mr-1 text-purple-500"></i> {{ $vehicle->reservations_count }} réservation(s)
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center space-x-3 mt-4 md:mt-0">
                <a href="{{ route('company.vehicles.show', $vehicle) }}" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-200 rounded-md hover:bg-indigo-50 transition flex items-center shadow-sm hover:shadow">
                    <i class="fas fa-eye mr-1.5 text-indigo-500"></i> Voir
                </a>
                <a href="{{ route('company.vehicles.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition flex items-center shadow-sm hover:shadow">
                    <i class="fas fa-arrow-left mr-1.5 text-gray-500"></i> Retour
                </a>
            </div>
        </div>
    </div>
    
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm animate-pulse" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2 text-lg"></i>
                <p class="font-bold">Veuillez corriger les erreurs suivantes:</p>
            </div>
            <ul class="list-disc pl-10 mt-2 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- Tabs Navigation -->
    <div class="mb-6 bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <div class="flex border-b border-gray-200" id="vehicle-tabs">
            <button class="tab-btn px-6 py-3 font-medium text-sm text-gray-700 border-b-2 border-indigo-500 bg-indigo-50 flex items-center" data-target="basic-info">
                <i class="fas fa-info-circle mr-2 text-indigo-500"></i> Informations de base
            </button>
            <button class="tab-btn px-6 py-3 font-medium text-sm text-gray-600 hover:text-gray-800 flex items-center" data-target="features-section">
                <i class="fas fa-list-ul mr-2 text-gray-500"></i> Caractéristiques
            </button>
            <button class="tab-btn px-6 py-3 font-medium text-sm text-gray-600 hover:text-gray-800 flex items-center" data-target="photos-section">
                <i class="fas fa-images mr-2 text-gray-500"></i> Photos <span class="ml-1 rounded-full bg-indigo-100 px-2 text-xs text-indigo-800">{{ $vehicle->photos->count() }}</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('company.vehicles.update', $vehicle) }}" enctype="multipart/form-data" class="p-6" id="edit-vehicle-form">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="tab-content" id="basic-info">
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm mb-6">
                    <h3 class="font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Informations du véhicule</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="brand" class="block text-sm font-medium text-gray-700">Marque <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tag text-gray-400"></i>
                                    </div>
                                    <input type="text" name="brand" id="brand" value="{{ old('brand', $vehicle->brand) }}" class="pl-10 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="model" class="block text-sm font-medium text-gray-700">Modèle <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-car-side text-gray-400"></i>
                                    </div>
                                    <input type="text" name="model" id="model" value="{{ old('model', $vehicle->model) }}" class="pl-10 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700">Année <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="number" name="year" id="year" value="{{ old('year', $vehicle->year) }}" min="1900" max="{{ date('Y') + 1 }}" class="pl-10 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="license_plate" class="block text-sm font-medium text-gray-700">Plaque d'immatriculation <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate', $vehicle->license_plate) }}" class="pl-10 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="transmission" class="block text-sm font-medium text-gray-700">Transmission <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-cog text-gray-400"></i>
                                    </div>
                                    <select name="transmission" id="transmission" class="pl-10 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        <option value="automatic" {{ old('transmission', $vehicle->transmission) == 'automatic' ? 'selected' : '' }}>Automatique</option>
                                        <option value="manual" {{ old('transmission', $vehicle->transmission) == 'manual' ? 'selected' : '' }}>Manuelle</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="fuel_type" class="block text-sm font-medium text-gray-700">Type de carburant <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-gas-pump text-gray-400"></i>
                                    </div>
                                    <select name="fuel_type" id="fuel_type" class="pl-10 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        <option value="gasoline" {{ old('fuel_type', $vehicle->fuel_type) == 'gasoline' ? 'selected' : '' }}>Essence</option>
                                        <option value="diesel" {{ old('fuel_type', $vehicle->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ old('fuel_type', $vehicle->fuel_type) == 'electric' ? 'selected' : '' }}>Électrique</option>
                                        <option value="hybrid" {{ old('fuel_type', $vehicle->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybride</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="seats" class="block text-sm font-medium text-gray-700">Nombre de places <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-users text-gray-400"></i>
                                    </div>
                                    <input type="number" name="seats" id="seats" value="{{ old('seats', $vehicle->seats) }}" min="1" max="50"class="pl-10 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="price_per_day" class="block text-sm font-medium text-gray-700">Prix par jour (€) <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-euro-sign text-gray-400"></i>
                                    </div>
                                    <input type="number" name="price_per_day" id="price_per_day" value="{{ old('price_per_day', $vehicle->price_per_day) }}" min="0" step="0.01" class="pl-10 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Status -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm mb-6">
                    <h3 class="font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Statut</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center p-4 bg-white border rounded-lg shadow-sm transform transition hover:shadow-md">
                            <div class="mr-3">
                                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $vehicle->is_active) ? 'checked' : '' }}
                                        class="absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer focus:outline-none toggle-checkbox"/>
                                    <label for="is_active" class="block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer toggle-label"></label>
                                </div>
                            </div>
                            <div>
                                <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer">
                                    Actif (visible sur la plateforme)
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Les clients pourront voir ce véhicule sur le site.</p>
                            </div>
                            <!-- Status indicator -->
                            <div class="ml-auto">
                                <span class="{{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} text-xs px-2 py-1 rounded-full">
                                    {{ $vehicle->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-white border rounded-lg shadow-sm transform transition hover:shadow-md">
                            <div class="mr-3">
                                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                    <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $vehicle->is_available) ? 'checked' : '' }}
                                        class="absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer focus:outline-none toggle-checkbox"/>
                                    <label for="is_available" class="block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer toggle-label"></label>
                                </div>
                            </div>
                            <div>
                                <label for="is_available" class="text-sm font-medium text-gray-700 cursor-pointer">
                                    Disponible à la réservation
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Les clients pourront réserver ce véhicule.</p>
                            </div>
                            <!-- Status indicator -->
                            <div class="ml-auto">
                                <span class="{{ $vehicle->is_available ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} text-xs px-2 py-1 rounded-full">
                                    {{ $vehicle->is_available ? 'Disponible' : 'Indisponible' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm">
                    <h3 class="font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Description</h3>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Détails du véhicule</label>
                        <textarea name="description" id="description" rows="4" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Décrivez les caractéristiques et avantages de ce véhicule...">{{ old('description', $vehicle->description) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Une bonne description permet d'augmenter les chances de location.</p>
                    </div>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="tab-content hidden" id="features-section">
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm">
                    <h3 class="font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Équipements</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php
                            $features = [
                                'air_conditioning' => ['Climatisation', 'fa-snowflake'],
                                'gps' => ['GPS', 'fa-map-marker-alt'],
                                'bluetooth' => ['Bluetooth', 'fa-bluetooth-b'],
                                'usb' => ['Port USB', 'fa-usb'],
                                'heated_seats' => ['Sièges chauffants', 'fa-fire'],
                                'sunroof' => ['Toit ouvrant', 'fa-sun'],
                                'cruise_control' => ['Régulateur de vitesse', 'fa-tachometer-alt'],
                                'parking_sensors' => ['Capteurs de stationnement', 'fa-parking'],
                                'backup_camera' => ['Caméra de recul', 'fa-camera'],
                                'child_seats' => ['Sièges enfants', 'fa-baby'],
                                'wifi' => ['Wi-Fi', 'fa-wifi'],
                                'leather_seats' => ['Sièges en cuir', 'fa-couch']
                            ];
                            $vehicleFeatures = old('features', $vehicle->features) ?? [];
                        @endphp
                        
                        @foreach($features as $key => $feature)
                            <div class="bg-white rounded-lg p-3 border hover:shadow-md transition duration-150 feature-selector {{ is_array($vehicleFeatures) && in_array($key, $vehicleFeatures) ? 'border-indigo-300 bg-indigo-50' : 'border-gray-200' }}">
                                <div class="flex items-center">
                                    <input type="checkbox" name="features[]" id="feature_{{ $key }}" value="{{ $key }}" 
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                           {{ is_array($vehicleFeatures) && in_array($key, $vehicleFeatures) ? 'checked' : '' }}>
                                    <label for="feature_{{ $key }}" class="ml-2 block text-sm text-gray-700 cursor-pointer select-none flex items-center">
                                        <i class="fas {{ $feature[1] }} text-indigo-500 mr-2 fa-fw"></i> {{ $feature[0] }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Photos Section -->
            <div class="tab-content hidden" id="photos-section">
                <div class="p-4 mb-6 bg-blue-50 border-l-4 border-blue-500 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Gestion des photos</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Vous pouvez ajouter jusqu'à 5 photos par véhicule</li>
                                    <li>Sélectionnez une photo comme principale pour qu'elle apparaisse en premier</li>
                                    <li>Les formats acceptés sont JPG, PNG et GIF (max 2MB)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Current Photos with enhanced UI -->
                @if($vehicle->photos->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm mb-6">
                        <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-4">
                            <h3 class="font-semibold text-gray-700 flex items-center">
                                <i class="fas fa-images text-indigo-500 mr-2"></i>
                                Photos actuelles <span class="ml-2 text-sm text-gray-500">({{ $vehicle->photos->count() }}/5)</span>
                            </h3>
                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full" id="photo-counter-status">
                                {{ $vehicle->photos->count() }} photo(s) sur 5 maximum
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="current-photos-container">
                            @foreach($vehicle->photos as $photo)
                                <div class="photo-card relative bg-white rounded-lg overflow-hidden shadow-md border border-gray-200 group hover:shadow-lg transition-all duration-300 {{ $photo->is_primary ? 'ring-2 ring-yellow-400' : '' }}" data-photo-id="{{ $photo->id }}">
                                    <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                                            class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
                                    </div>
                                    
                                    <div class="absolute top-2 right-2 flex space-x-1">
                                        <div class="photo-action-btn bg-white text-red-500 hover:bg-red-100 p-2 rounded-full shadow-md transition-all" title="Supprimer cette photo">
                                            <input type="checkbox" name="photos_to_delete[]" value="{{ $photo->id }}" id="delete_{{ $photo->id }}" class="sr-only photo-delete-checkbox">
                                            <label for="delete_{{ $photo->id }}" class="cursor-pointer flex items-center justify-center w-5 h-5">
                                                <i class="fas fa-trash-alt"></i>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="relative p-3 bg-white">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <input type="radio" name="primary_photo_id" value="{{ $photo->id }}" id="primary_{{ $photo->id }}" 
                                                    class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 border-gray-300 primary-photo-radio"
                                                    {{ $photo->is_primary ? 'checked' : '' }}>
                                                <label for="primary_{{ $photo->id }}" class="text-sm font-medium text-gray-700 cursor-pointer">
                                                    Photo principale
                                                </label>
                                            </div>
                                            
                                            @if($photo->is_primary)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-star mr-1"></i> Principale
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="mt-2 text-xs text-gray-500 truncate">
                                            {{ basename($photo->path) }}
                                        </div>
                                    </div>
                                    
                                    <div class="absolute inset-0 flex-col justify-center items-center bg-red-500 bg-opacity-80 text-white opacity-0 delete-overlay transition-opacity duration-300 hidden">
                                        <div class="text-center p-4">
                                            <i class="fas fa-exclamation-triangle text-4xl mb-2"></i>
                                            <p class="font-bold mb-2">Supprimer cette photo?</p>
                                            <div class="flex justify-center space-x-2">
                                                <button type="button" class="confirm-delete px-3 py-1 bg-white text-red-500 rounded hover:bg-gray-100">
                                                    Oui
                                                </button>
                                                <button type="button" class="cancel-delete px-3 py-1 bg-transparent border border-white text-white rounded hover:bg-red-600">
                                                    Non
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Enhanced file upload section -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-4">
                        <h3 class="font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-cloud-upload-alt text-indigo-500 mr-2"></i>
                            Ajouter des photos
                        </h3>
                        <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full">
                            {{ 5 - $vehicle->photos->count() }} emplacement(s) disponible(s)
                        </span>
                    </div>
                    
                    <div class="mt-2 p-6 border-2 border-gray-300 border-dashed rounded-lg bg-white relative transition-all duration-300 hover:bg-gray-50 hover:border-indigo-300" id="dropzone-container">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="new_photos" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Sélectionner des fichiers</span>
                                    <input id="new_photos" name="new_photos[]" type="file" class="sr-only" multiple accept="image/*">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                            </div>
        </div>
                    
                    <div id="photo-preview-container" class="mt-6 hidden">
                        <h4 class="font-medium text-sm text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-image text-indigo-500 mr-1"></i> 
                            Aperçu des photos sélectionnées
                            <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full" id="selected-count"></span>
                        </h4>
                        <div id="photo-preview" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3"></div>
                    </div>
                    
                    <div class="hidden bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-4" id="max-photos-warning">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Vous avez atteint le nombre maximum de photos pour ce véhicule.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex items-center justify-end space-x-3" id="form-actions">
                <button type="button" id="cancel-btn" onclick="window.location='{{ route('company.vehicles.index') }}'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center">
                    <i class="fas fa-times mr-1.5"></i> Annuler
                </button>
                <button type="submit" id="submit-btn" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 items-center">
                    <i class="fas fa-save mr-1.5"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Toggle Switch Styling */
    .toggle-checkbox:checked {
        @apply right-0 border-indigo-600;
        right: 0;
        border-color: #4f46e5;
    }
    .toggle-checkbox:checked + .toggle-label {
        @apply bg-indigo-600;
        background-color: #4f46e5;
    }
    
    /* Feature selector styling */
    .feature-selector:hover {
        @apply border-indigo-300;
    }
    
    .feature-selector input:checked + label {
        @apply text-indigo-700;
    }
    
    /* Photo delete checked state */
    .photo-delete-checkbox:checked + label {
        @apply bg-red-600 text-white;
    }
    
    /* Animation for switching tabs */
    .tab-content {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Dropzone styling */
    #dropzone-container.dragover {
        @apply border-indigo-400 bg-indigo-50;
    }

    /* Styles pour les prévisualisations de photos */
    #photo-preview > div {
        transition: all 0.3s ease;
    }
    
    #photo-preview > div:hover {
        transform: translateY(-3px);
    }
    
    /* Animation de l'effet de scale pour le dropzone */
    .scale-102 {
        transform: scale(1.02);
    }
    
    /* Style pour les notifications */
    .notification {
        max-width: 400px;
    }
    
    /* Amélioration des animations */
    @keyframes pulse-indigo {
        0%, 100% {
            background-color: rgba(199, 210, 254, 0.2);
        }
        50% {
            background-color: rgba(199, 210, 254, 0.5);
        }
    }
    
    #dropzone-container.dragover {
        animation: pulse-indigo 1.5s ease infinite;
    }
    
    /* Style pour loader */
    #upload-progress-container {
        transition: opacity 0.3s ease;
    }
</style>

@endpush

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    setupTabs();
    
    // Photo management
    setupPhotoDeleters();
    setupPrimaryPhotoSelection();
    setupPhotoUpload();
    
    // Core functions for tab switching
    function setupTabs() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                
                // Hide all tabs and show selected
                tabContents.forEach(content => content.classList.add('hidden'));
                document.getElementById(targetId).classList.remove('hidden');
                
                // Update button styles
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-indigo-500', 'bg-indigo-50', 'text-gray-700');
                    btn.classList.add('text-gray-600', 'hover:text-gray-800');
                });
                
                this.classList.remove('text-gray-600', 'hover:text-gray-800');
                this.classList.add('border-b-2', 'border-indigo-500', 'bg-indigo-50', 'text-gray-700');
            });
        });
    }
    
    // Core functions for photo deletion
    function setupPhotoDeleters() {
        const photoDeleteCheckboxes = document.querySelectorAll('.photo-delete-checkbox');
        
        photoDeleteCheckboxes.forEach(checkbox => {
            const photoCard = checkbox.closest('.photo-card');
            const deleteLabel = checkbox.nextElementSibling;
            const deleteOverlay = photoCard.querySelector('.delete-overlay');
            
            // Show delete confirmation
            deleteLabel.addEventListener('click', function(e) {
                e.preventDefault();
                deleteOverlay.classList.remove('hidden');
                deleteOverlay.classList.add('flex', 'opacity-100');
            });
            
            // Confirm deletion
            photoCard.querySelector('.confirm-delete').addEventListener('click', function() {
                checkbox.checked = true;
                photoCard.classList.add('border-red-500');
                photoCard.querySelector('img').classList.add('opacity-50');
                
                // Add visual indicator
                const indicator = document.createElement('div');
                indicator.className = 'absolute top-0 left-0 bg-red-500 text-white px-2 py-1 text-xs font-bold m-2 rounded';
                indicator.innerHTML = '<i class="fas fa-trash-alt mr-1"></i> Sera supprimée';
                photoCard.appendChild(indicator);
                
                // Hide overlay
                hideOverlay(deleteOverlay);
            });
            
            // Cancel deletion
            photoCard.querySelector('.cancel-delete').addEventListener('click', function() {
                checkbox.checked = false;
                hideOverlay(deleteOverlay);
            });
        });
        
        function hideOverlay(overlay) {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }, 300);
        }
    }
    
    // Core functions for primary photo selection
    function setupPrimaryPhotoSelection() {
        const primaryPhotoRadios = document.querySelectorAll('.primary-photo-radio');
        
        // Handle primary photo selection
        primaryPhotoRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.photo-card').forEach(card => {
                    card.classList.remove('ring-2', 'ring-yellow-400');
                });
                
                if (this.checked) {
                    this.closest('.photo-card').classList.add('ring-2', 'ring-yellow-400');
                }
            });
        });
        
        // Prevent deleting primary photo
        document.getElementById('edit-vehicle-form').addEventListener('submit', function(e) {
            const primaryPhotoId = document.querySelector('.primary-photo-radio:checked')?.value;
            const isPrimaryMarkedForDeletion = primaryPhotoId && 
                document.querySelector(`input[name="photos_to_delete[]"][value="${primaryPhotoId}"]:checked`);
                
            if (isPrimaryMarkedForDeletion) {
                alert('Vous ne pouvez pas supprimer la photo principale. Veuillez d\'abord sélectionner une autre photo comme principale.');
                e.preventDefault();
            }
        });
    }
    
    // Core functions for photo upload
    function setupPhotoUpload() {
        // 1. Récupérer tous les éléments HTML nécessaires
        const photoInput = document.getElementById('new_photos');
        const photoPreview = document.getElementById('photo-preview');
        const previewContainer = document.getElementById('photo-preview-container');
        const selectedCount = document.getElementById('selected-count');
        const maxPhotosWarning = document.getElementById('max-photos-warning');
        const dropzone = document.getElementById('dropzone-container');
        
        // 2. Définir les paramètres et limites
        const MAX_PHOTOS = 5; // Nombre maximum de photos permises
        const MAX_SIZE = 2 * 1024 * 1024; // 2MB en octets
        const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif']; // Types de fichiers acceptés
        const currentPhotoCount = {{ $vehicle->photos->count() }}; // Nombre actuel de photos
        const remainingSlots = MAX_PHOTOS - currentPhotoCount; // Places disponibles
        
        // 3. Ajouter l'événement pour sélectionner des fichiers
        photoInput.addEventListener('change', function() {
            // Quand l'utilisateur sélectionne des fichiers, on les traite
            traiterFichiers(this.files);
        });
        
        // 4. Configurer le glisser-déposer (drag and drop)
        // Quand on survole la zone avec un fichier
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault(); // Empêcher le comportement par défaut
            this.classList.add('border-indigo-400', 'bg-indigo-50'); // Changer l'apparence
        });
        
        // Quand on quitte la zone de dépôt
        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-indigo-400', 'bg-indigo-50'); // Restaurer l'apparence
        });
        
        // Quand on dépose les fichiers
        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-indigo-400', 'bg-indigo-50');
            traiterFichiers(e.dataTransfer.files); // Traiter les fichiers déposés
        });
        
        // 5. Fonction pour traiter les fichiers sélectionnés
        function traiterFichiers(fichiers) {
            // Vérifier si des fichiers ont été sélectionnés
            if (!fichiers || fichiers.length === 0) {
                previewContainer.classList.add('hidden'); // Cacher le conteneur de prévisualisation
                return;
            }
            
            // Vider la prévisualisation existante
            photoPreview.innerHTML = '';
            
            // Filtrer les fichiers valides
            let fichiersValides = [];
            
            for (let i = 0; i < fichiers.length; i++) {
                const fichier = fichiers[i];
                
                // Vérifier le type de fichier
                if (!ALLOWED_TYPES.includes(fichier.type)) {
                    afficherMessage(`Le fichier "${fichier.name}" n'est pas une image valide.`, 'error');
                    continue; // Passer au fichier suivant
                }
                
                // Vérifier la taille du fichier
                if (fichier.size > MAX_SIZE) {
                    afficherMessage(`Le fichier "${fichier.name}" dépasse la taille maximale de 2MB.`, 'error');
                    continue; // Passer au fichier suivant
                }
                
                // Ajouter le fichier valide à notre tableau
                fichiersValides.push(fichier);
            }
            
            // Vérifier si on dépasse le nombre de places disponibles
            if (fichiersValides.length > remainingSlots) {
                maxPhotosWarning.classList.remove('hidden'); // Afficher l'avertissement
                afficherMessage(`Vous pouvez ajouter au maximum ${remainingSlots} photo(s).`, 'warning');
                
                // Limiter le nombre de fichiers aux places disponibles
                fichiersValides = fichiersValides.slice(0, remainingSlots);
            } else {
                maxPhotosWarning.classList.add('hidden'); // Cacher l'avertissement
            }
            
            // Mettre à jour l'input de fichiers
            mettreAJourInputFichiers(fichiersValides);
            
            // Créer les prévisualisations
            creerPrevisualisations(fichiersValides);
            
            // Mettre à jour le compteur
            selectedCount.textContent = photoInput.files.length + ' photo(s)';
            
            // Afficher le conteneur de prévisualisation
            previewContainer.classList.remove('hidden');
        }
        
        // 6. Fonction pour créer les prévisualisations des images
        function creerPrevisualisations(fichiers) {
            for (let i = 0; i < fichiers.length; i++) {
                const fichier = fichiers[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Créer un élément div pour la prévisualisation
                    const div = document.createElement('div');
                    div.className = 'relative bg-white rounded shadow-sm border';
                    
                    // Remplir le div avec l'image et les infos
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="${fichier.name}" class="w-full h-32 object-cover">
                        <div class="absolute top-0 left-0 p-1 bg-black bg-opacity-50 text-white text-xs">
                            ${formaterTaille(fichier.size)}
                        </div>
                        <button type="button" class="absolute top-1 right-1 bg-white p-1 rounded-full shadow-sm text-red-500" 
                                data-index="${i}">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="p-2 text-xs truncate">
                            ${fichier.name}
                        </div>
                    `;
                    
                    // Ajouter la prévisualisation au conteneur
                    photoPreview.appendChild(div);
                    
                    // Configurer le bouton de suppression
                    const boutonSupprimer = div.querySelector('button');
                    boutonSupprimer.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        supprimerFichier(index);
                        div.remove();
                        
                        // Mettre à jour l'interface
                        if (photoInput.files.length === 0) {
                            previewContainer.classList.add('hidden');
                        } else {
                            selectedCount.textContent = photoInput.files.length + ' photo(s)';
                        }
                    });
                };
                
                // Lire le fichier comme une URL de données
                reader.readAsDataURL(fichier);
            }
        }
        
        // 7. Fonction pour mettre à jour l'input de fichiers
        function mettreAJourInputFichiers(fichiers) {
            const dt = new DataTransfer(); // Créer un nouvel objet DataTransfer
            
            // Ajouter chaque fichier
            for (let i = 0; i < fichiers.length; i++) {
                dt.items.add(fichiers[i]);
            }
            
            // Mettre à jour la liste des fichiers de l'input
            photoInput.files = dt.files;
        }
        
        // 8. Fonction pour supprimer un fichier
        function supprimerFichier(index) {
            // Vérifier s'il y a des fichiers
            if (!photoInput.files || photoInput.files.length === 0) return;
            
            // Créer un tableau de tous les fichiers sauf celui à supprimer
            const fichiers = [];
            for (let i = 0; i < photoInput.files.length; i++) {
                if (i !== index) {
                    fichiers.push(photoInput.files[i]);
                }
            }
            
            // Mettre à jour l'input
            mettreAJourInputFichiers(fichiers);
        }
        
        // 9. Fonction pour formater la taille des fichiers
        function formaterTaille(octets) {
            if (octets < 1024) return octets + ' B'; // Octets
            if (octets < 1048576) return (octets / 1024).toFixed(1) + ' KB'; // Kilooctets
            return (octets / 1048576).toFixed(1) + ' MB'; // Mégaoctets
        }
        
        // 10. Fonction pour afficher des messages
        function afficherMessage(message, type) {
            // Créer l'élément de message
            const toast = document.createElement('div');
            
            // Définir la couleur selon le type de message
            let couleur;
            if (type === 'error') {
                couleur = 'bg-red-100 text-red-800'; // Rouge pour les erreurs
            } else if (type === 'warning') {
                couleur = 'bg-yellow-100 text-yellow-800'; // Jaune pour les avertissements
            } else {
                couleur = 'bg-blue-100 text-blue-800'; // Bleu pour les infos
            }
            
            // Configurer le style du message
            toast.className = `fixed top-4 right-4 p-3 rounded-lg shadow-md z-50 ${couleur}`;
            toast.innerHTML = message;
            
            // Ajouter le message à la page
            document.body.appendChild(toast);
            
            // Supprimer le message après 3 secondes
            setTimeout(function() {
                toast.remove();
            }, 3000);
        }
    }
});
</script>
<script>
    // Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get toggle checkboxes
    const isActiveToggle = document.getElementById('is_active');
    const isAvailableToggle = document.getElementById('is_available');
    
    // Get status indicators
    const activeStatusIndicator = isActiveToggle.closest('.flex.items-center').querySelector('span');
    const availableStatusIndicator = isAvailableToggle.closest('.flex.items-center').querySelector('span');
    
    // Setup toggle handlers
    setupToggle(isActiveToggle, activeStatusIndicator, 'Actif', 'Inactif');
    setupToggle(isAvailableToggle, availableStatusIndicator, 'Disponible', 'Indisponible');
    
    // Function to handle toggle changes with visual feedback
    function setupToggle(toggle, indicator, activeText, inactiveText) {
        // Initial setup for card styling based on current state
        updateCardStyle(toggle);
        
        toggle.addEventListener('change', function() {
            // Update the status indicator text and style
            if (this.checked) {
                indicator.textContent = activeText;
                indicator.classList.remove('bg-gray-100', 'text-gray-800');
                indicator.classList.add('bg-green-100', 'text-green-800');
                
                // Show success animation
                showFeedback(this, 'success');
            } else {
                indicator.textContent = inactiveText;
                indicator.classList.remove('bg-green-100', 'text-green-800');
                indicator.classList.add('bg-gray-100', 'text-gray-800');
                
                // Show info animation
                showFeedback(this, 'info');
            }
            
            // Update card style
            updateCardStyle(this);
        });
    }
    
    // Update the card style based on toggle state
    function updateCardStyle(toggle) {
        const card = toggle.closest('.flex.items-center');
        
        if (toggle.checked) {
            card.classList.add('border-green-200');
            card.classList.remove('border-gray-200');
            
            // Subtle green background for active cards
            card.style.backgroundColor = '#f0fdf4'; // Light green background
        } else {
            card.classList.remove('border-green-200');
            card.classList.add('border-gray-200');
            card.style.backgroundColor = ''; // Reset to default
        }
    }
    
    // Show visual feedback animation
    function showFeedback(element, type) {
        const card = element.closest('.flex.items-center');
        const feedback = document.createElement('div');
        
        // Style the feedback element
        feedback.className = 'absolute right-0 top-0 bottom-0 flex items-center pr-3 transition-all duration-500 opacity-0';
        feedback.style.transform = 'translateX(10px)';
        
        // Set icon and color based on feedback type
        if (type === 'success') {
            feedback.innerHTML = '<i class="fas fa-check-circle text-green-500 text-lg"></i>';
        } else {
            feedback.innerHTML = '<i class="fas fa-info-circle text-gray-500 text-lg"></i>';
        }
        
        // Make card position relative for absolute positioning of feedback
        card.style.position = 'relative';
        card.style.overflow = 'hidden';
        
        // Add and animate the feedback
        card.appendChild(feedback);
        
        // Apply pulse animation to the card
        card.classList.add('transition-all', 'duration-300');
        if (type === 'success') {
            card.style.boxShadow = '0 0 0 2px rgba(34, 197, 94, 0.3)';
        } else {
            card.style.boxShadow = '0 0 0 2px rgba(156, 163, 175, 0.3)';
        }
        
        // Animate the feedback icon
        setTimeout(() => {
            feedback.style.opacity = '1';
            feedback.style.transform = 'translateX(0)';
        }, 50);
        
        // Remove animation after a delay
        setTimeout(() => {
            feedback.style.opacity = '0';
            feedback.style.transform = 'translateX(10px)';
            card.style.boxShadow = '';
            
            // Remove element after fade out
            setTimeout(() => {
                feedback.remove();
            }, 500);
        }, 1500);
    }
    
    // Add hover effect for status cards
    const statusCards = document.querySelectorAll('#basic-info .rounded-lg.shadow-sm:nth-child(2) .flex.items-center');
    statusCards.forEach(card => {
        card.classList.add('transition-all', 'duration-300');
        
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow');
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow');
            this.style.transform = '';
        });
    });
});
</script>
@endsection