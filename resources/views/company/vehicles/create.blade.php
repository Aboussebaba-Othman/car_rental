@extends('layouts.company')

@section('title', 'Ajouter un véhicule')
@section('header', 'Ajouter un nouveau véhicule')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- En-tête avec breadcrumb -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('company.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Tableau de bord
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('company.vehicles.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors duration-200 md:ml-2">Véhicules</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-indigo-600 md:ml-2">Ajouter un véhicule</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-bold text-gray-900 pt-4">Ajouter un nouveau véhicule</h2>
                <p class="mt-1 text-sm text-gray-600">Complétez ce formulaire pour ajouter un véhicule à votre flotte</p>
            </div>
            <a href="{{ route('company.vehicles.index') }}" class="mt-3 md:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500 group-hover:text-indigo-500 transition-colors duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Retour aux véhicules
            </a>
        </div>
    </div>
    
    @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-md overflow-hidden transform transition-all duration-300">
            <div class="p-4 flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</p>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <!-- Progression du formulaire -->
        <div class="border-b border-gray-200 bg-gray-50">
            <div class="px-8 py-6">
                <nav class="flex justify-center">
                    <ol class="flex items-center w-full max-w-3xl">
                        <li class="flex items-center text-indigo-600 relative">
                            <span id="step-1-indicator" class="h-12 w-12 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 font-bold text-lg shadow-sm transition-all duration-300">1</span>
                            <span class="ml-2 text-sm font-medium">Informations de base</span>
                            <div class="flex-1 border-t-2 border-indigo-300 ml-2"></div>
                        </li>
                        <li class="flex items-center text-gray-400 relative flex-1">
                            <span id="step-2-indicator" class="h-12 w-12 flex items-center justify-center rounded-full bg-gray-100 font-bold text-lg shadow-sm transition-all duration-300">2</span>
                            <span class="ml-2 text-sm font-medium">Caractéristiques</span>
                            <div class="flex-1 border-t-2 border-gray-300 ml-2"></div>
                        </li>
                        <li class="flex items-center text-gray-400 relative">
                            <span id="step-3-indicator" class="h-12 w-12 flex items-center justify-center rounded-full bg-gray-100 font-bold text-lg shadow-sm transition-all duration-300">3</span>
                            <span class="ml-2 text-sm font-medium">Photos</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <form method="POST" action="{{ route('company.vehicles.store') }}" enctype="multipart/form-data" id="vehicleForm" class="divide-y divide-gray-200">
            @csrf
            
            <!-- Étape 1: Informations de base -->
            <div id="step-1" class="px-12 py-8 space-y-8 block">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Colonne 1 -->
                    <div class="space-y-6">
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <input type="text" name="brand" id="brand" value="{{ old('brand') }}" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md transition-all border px-3 py-2  border duration-200" 
                                       placeholder="Ex: Renault, Peugeot..." required>

                            </div>
                        </div>
                        
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <input type="text" name="model" id="model" value="{{ old('model') }}" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all border px-3 py-2 duration-200" 
                                       placeholder="Ex: Clio, 3008..." required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="number" name="year" id="year" value="{{ old('year') }}" 
                                       min="1990" max="{{ date('Y') + 1 }}" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all border px-3 py-2 duration-200" 
                                       placeholder="{{ date('Y') }}" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-1">Immatriculation</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </div>
                                <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate') }}" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg uppercase transition-all border px-3 py-2 duration-200" 
                                       placeholder="Ex: AB-123-CD" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Colonne 2 -->
                    <div class="space-y-6">
                        <div>
                            <label for="transmission" class="block text-sm font-medium text-gray-700 mb-1">Transmission</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <select name="transmission" id="transmission" 
                                        class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all border px-3 py-2 duration-200" required>
                                    <option value="" disabled selected>Sélectionnez une transmission</option>
                                    <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatique</option>
                                    <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manuelle</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Type de carburant</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <select name="fuel_type" id="fuel_type" 
                                        class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all border px-3 py-2 duration-200" required>
                                    <option value="" disabled selected>Sélectionnez un type de carburant</option>
                                    <option value="gasoline" {{ old('fuel_type') == 'gasoline' ? 'selected' : '' }}>Essence</option>
                                    <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Électrique</option>
                                    <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybride</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="seats" class="block text-sm font-medium text-gray-700 mb-1">Nombre de places</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <input type="number" name="seats" id="seats" value="{{ old('seats') }}" 
                                       min="1" max="50" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all border px-3 py-2 duration-200" 
                                       placeholder="5" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="price_per_day" class="block text-sm font-medium text-gray-700 mb-1">Prix par jour (€)</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                                <input type="number" name="price_per_day" id="price_per_day" value="{{ old('price_per_day') }}" 
                                       min="1" step="0.01" 
                                       class="pl-7 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all border px-3 py-2 duration-200" 
                                       placeholder="50.00" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">/jour</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <div class="relative rounded-md shadow-sm">
                        <textarea name="description" id="description" rows="4" 
                                 class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all border px-3 py-2 duration-200" 
                                 placeholder="Décrivez votre véhicule, ses points forts, son état...">{{ old('description') }}</textarea>
                    </div>
                    <div class="mt-1 flex justify-between items-center">
                        <p class="text-xs text-gray-500">
                            <span id="charCount">0</span>/1000 caractères
                        </p>
                        <div class="text-xs text-gray-500">
                            <span id="charCountStatus" class="hidden px-2 py-1 rounded-full bg-green-100 text-green-800">Parfait !</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="button" id="to-step-2" class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all border  duration-200 transform hover:-translate-y-0.5">
                        Continuer
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Étape 2: Caractéristiques -->
            <div id="step-2" class="px-8 py-8 hidden">
                <div class="mb-8">
                    <h3 class="text-xl font-medium text-gray-900">Caractéristiques et équipements</h3>
                    <p class="mt-1 text-sm text-gray-600">Sélectionnez les équipements disponibles dans ce véhicule</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $features = [
                            'air_conditioning' => ['Climatisation', 'snowflake'],
                            'gps' => ['GPS Navigation', 'map-pin'],
                            'bluetooth' => ['Bluetooth', 'wifi'],
                            'usb' => ['Port USB', 'usb'],
                            'heated_seats' => ['Sièges chauffants', 'fire'],
                            'sunroof' => ['Toit ouvrant', 'sun'],
                            'cruise_control' => ['Régulateur de vitesse', 'trending-up'],
                            'parking_sensors' => ['Capteurs de stationnement', 'radio'],
                            'backup_camera' => ['Caméra de recul', 'camera'],
                            'child_seats' => ['Sièges enfants', 'users'],
                            'wifi' => ['Wi-Fi', 'wifi'],
                            'leather_seats' => ['Sièges en cuir', 'layout'],
                            'automatic_parking' => ['Stationnement automatique', 'parking'],
                            'apple_carplay' => ['Apple CarPlay', 'smartphone'],
                            'android_auto' => ['Android Auto', 'smartphone'],
                            'electric_seats' => ['Sièges électriques', 'zap'],
                            'keyless_entry' => ['Accès sans clé', 'key'],
                            'start_button' => ['Démarrage sans clé', 'power']
                        ];
                        
                        $icons = [
                            'snowflake' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />',
                            'map-pin' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />',
                            'wifi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />',
                            'usb' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />',
                            'fire' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />',
                            'sun' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />',
                            'trending-up' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />',
                            'radio' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />',
                            'camera' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />',
                            'users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />',
                            'layout' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />',
                            'parking' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />',
                            'smartphone' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />',
                            'zap' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />',
                            'key' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />',
                            'power' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />'
                        ];
                    @endphp
                    
                    @foreach($features as $key => $feature)
                        <div class="relative flex items-start p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="features[]" id="feature_{{ $key }}" value="{{ $key }}" 
                                       class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-all cursor-pointer"
                                       {{ is_array(old('features')) && in_array($key, old('features')) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="feature_{{ $key }}" class="font-medium text-gray-700 cursor-pointer flex items-center">
                                    <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            {!! $icons[$feature[1]] !!}
                                        </svg>
                                    </div>
                                    {{ $feature[0] }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-10 flex justify-between">
                    <button type="button" id="back-to-step-1" class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Précédent
                    </button>
                    <button type="button" id="to-step-3" class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Continuer
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Étape 3: Photos -->
            <div id="step-3" class="px-8 py-8 hidden">
                <div class="mb-8">
                    <h3 class="text-xl font-medium text-gray-900">Photos du véhicule</h3>
                    <p class="mt-1 text-sm text-gray-600">Ajoutez jusqu'à 10 photos de votre véhicule pour attirer plus de clients</p>
                </div>
                
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-100 rounded-lg p-6 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-indigo-800">Conseils pour les photos</h3>
                            <div class="mt-2 text-sm leading-5 text-indigo-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>La première photo sera utilisée comme image principale</li>
                                    <li>Prenez des photos de l'extérieur sous différents angles</li>
                                    <li>Ajoutez des photos de l'intérieur (sièges, tableau de bord)</li>
                                    <li>Assurez-vous que les photos sont bien éclairées</li>
                                    <li>Taille maximale: 10MB par photo</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Zone de drop des photos -->
                <div class="mb-8">
                    <div id="dropzone" class="w-full p-10 border-2 border-dashed border-indigo-300 rounded-lg text-center cursor-pointer hover:bg-indigo-50 transition-all duration-200 group">
                        <input id="photos" name="photos[]" type="file" class="hidden" multiple accept="image/*">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-indigo-400 group-hover:text-indigo-500 transition-colors duration-200" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="mt-4 flex text-sm justify-center">
                            <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Choisir des fichiers</span>
                            </label>
                            <p class="pl-1 text-gray-500">ou glisser-déposer</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF jusqu'à 10MB</p>
                        <p id="drop-message" class="hidden mt-4 text-sm font-medium text-indigo-600">Déposez les photos ici</p>
                    </div>
                </div>
                
                <!-- Prévisualisation des photos -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-900">Photos sélectionnées (<span id="photo-count">0</span>/10)</h4>
                        <div class="flex space-x-3">
                            <button type="button" id="add-more-photos" class="text-sm text-indigo-600 hover:text-indigo-800 hidden transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Ajouter plus
                            </button>
                            <button type="button" id="clear-photos" class="text-sm text-red-600 hover:text-red-800 hidden transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Tout supprimer
                            </button>
                        </div>
                    </div>
                    
                    <div id="photo-preview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4"></div>
                    
                    <div id="no-photos-message" class="py-10 text-center text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p>Aucune photo sélectionnée</p>
                        <p class="text-sm mt-1">Ajoutez des photos pour donner vie à votre annonce</p>
                    </div>
                    
                    <!-- Aperçu des photos du véhicule -->
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 mb-3">Aperçu des photos principales:</p>
                        <div id="photo-gallery-preview" class="flex overflow-x-auto space-x-3 pb-2">
                            <div class="flex-shrink-0 w-32 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 flex justify-between">
                    <button type="button" id="back-to-step-2" class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        Précédent
                    </button>
                    <button type="submit" id="submit-button" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer le véhicule
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Animation pour le drag and drop */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    .pulse {
        animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Style pour l'affichage des miniatures */
    .thumbnail-container {
        position: relative;
        aspect-ratio: 3/2;
        overflow: hidden;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .thumbnail-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .thumbnail-container:hover img {
        transform: scale(1.05);
    }
    
    .thumbnail-container .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .thumbnail-container:hover .overlay {
        opacity: 1;
    }
    
    .thumbnail-container .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: white;
        border-radius: 9999px;
        padding: 0.25rem;
        opacity: 0.9;
        transition: opacity 0.2s ease, transform 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .thumbnail-container:hover .remove-btn {
        opacity: 1;
    }
    
    .thumbnail-container .remove-btn:hover {
        transform: scale(1.1);
        background: #fee2e2;
        color: #dc2626;
    }
    
    /* Styles pour le badge "Image principale" */
    .main-photo-badge {
        position: absolute;
        bottom: 0.5rem;
        left: 0.5rem;
        background: rgba(79, 70, 229, 0.9);
        color: white;
        font-size: 0.65rem;
        font-weight: 500;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    /* Styles pour les inputs */
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
    }
    
    /* Styles pour les boutons */
    button:focus {
        outline: none;
    }
    
    /* Styles pour les étapes actives */
    .step-active {
        background-color: #4F46E5;
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables pour les étapes
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const step3 = document.getElementById('step-3');
        
        const step1Indicator = document.getElementById('step-1-indicator');
        const step2Indicator = document.getElementById('step-2-indicator');
        const step3Indicator = document.getElementById('step-3-indicator');
        
        // Boutons de navigation
        const toStep2Button = document.getElementById('to-step-2');
        const backToStep1Button = document.getElementById('back-to-step-1');
        const toStep3Button = document.getElementById('to-step-3');
        const backToStep2Button = document.getElementById('back-to-step-2');
        
        // Navigation entre les étapes
        toStep2Button.addEventListener('click', function() {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            
            step1Indicator.classList.remove('bg-indigo-100', 'text-indigo-600');
            step1Indicator.classList.add('bg-indigo-600', 'text-white');
            
            step2Indicator.classList.remove('bg-gray-100', 'text-gray-400');
            step2Indicator.classList.add('bg-indigo-100', 'text-indigo-600');
            
            window.scrollTo(0, 0);
        });
        
        backToStep1Button.addEventListener('click', function() {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            
            step2Indicator.classList.remove('bg-indigo-100', 'text-indigo-600');
            step2Indicator.classList.add('bg-gray-100', 'text-gray-400');
            
            step1Indicator.classList.remove('bg-indigo-600', 'text-white');
            step1Indicator.classList.add('bg-indigo-100', 'text-indigo-600');
            
            window.scrollTo(0, 0);
        });
        
        toStep3Button.addEventListener('click', function() {
            step2.classList.add('hidden');
            step3.classList.remove('hidden');
            
            step2Indicator.classList.remove('bg-indigo-100', 'text-indigo-600');
            step2Indicator.classList.add('bg-indigo-600', 'text-white');
            
            step3Indicator.classList.remove('bg-gray-100', 'text-gray-400');
            step3Indicator.classList.add('bg-indigo-100', 'text-indigo-600');
            
            window.scrollTo(0, 0);
        });
        
        backToStep2Button.addEventListener('click', function() {
            step3.classList.add('hidden');
            step2.classList.remove('hidden');
            
            step3Indicator.classList.remove('bg-indigo-100', 'text-indigo-600');
            step3Indicator.classList.add('bg-gray-100', 'text-gray-400');
            
            step2Indicator.classList.remove('bg-indigo-600', 'text-white');
            step2Indicator.classList.add('bg-indigo-100', 'text-indigo-600');
            
            window.scrollTo(0, 0);
        });
        
        // Compteur de caractères pour la description
        const descriptionField = document.getElementById('description');
        const charCount = document.getElementById('charCount');
        const charCountStatus = document.getElementById('charCountStatus');
        
        descriptionField.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count > 0 && count <= 1000) {
                charCountStatus.classList.remove('hidden');
                charCountStatus.classList.remove('bg-red-100', 'text-red-800');
                charCountStatus.classList.add('bg-green-100', 'text-green-800');
                charCountStatus.textContent = 'Parfait !';
            } else if (count > 1000) {
                charCountStatus.classList.remove('hidden', 'bg-green-100', 'text-green-800');
                charCountStatus.classList.add('bg-red-100', 'text-red-800');
                charCountStatus.textContent = 'Trop long !';
            } else {
                charCountStatus.classList.add('hidden');
            }
        });
        
        // Initialiser le compteur au chargement
        if (descriptionField.value) {
            charCount.textContent = descriptionField.value.length;
        }
        
        // Gestion du drag and drop pour les photos
        const dropzone = document.getElementById('dropzone');
        const photosInput = document.getElementById('photos');
        const photoPreview = document.getElementById('photo-preview');
        const photoCount = document.getElementById('photo-count');
        const noPhotosMessage = document.getElementById('no-photos-message');
        const addMorePhotosButton = document.getElementById('add-more-photos');
        const clearPhotosButton = document.getElementById('clear-photos');
        const photoGalleryPreview = document.getElementById('photo-gallery-preview');
        const dropMessage = document.getElementById('drop-message');
        
        let files = [];
        
        // Événements pour le drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropzone.classList.add('border-indigo-500', 'bg-indigo-50');
            dropMessage.classList.remove('hidden');
        }
        
        function unhighlight() {
            dropzone.classList.remove('border-indigo-500', 'bg-indigo-50');
            dropMessage.classList.add('hidden');
        }
        
        dropzone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const newFiles = [...dt.files];
            handleFiles(newFiles);
        }
        
        photosInput.addEventListener('change', function() {
            const newFiles = [...this.files];
            handleFiles(newFiles);
        });
        
        function handleFiles(newFiles) {
            // Limiter à 10 photos
            const totalFiles = files.length + newFiles.length;
            if (totalFiles > 10) {
                alert('Vous ne pouvez pas ajouter plus de 10 photos.');
                return;
            }
            
            files = [...files, ...newFiles];
            updatePhotoPreview();
        }
        
        function updatePhotoPreview() {
            photoCount.textContent = files.length;
            
            // Afficher/masquer les messages et boutons
            if (files.length > 0) {
                noPhotosMessage.classList.add('hidden');
                addMorePhotosButton.classList.remove('hidden');
                clearPhotosButton.classList.remove('hidden');
            } else {
                noPhotosMessage.classList.remove('hidden');
                addMorePhotosButton.classList.add('hidden');
                clearPhotosButton.classList.add('hidden');
            }
            
            // Vider les prévisualisations
            photoPreview.innerHTML = '';
            photoGalleryPreview.innerHTML = '';
            
            // Créer les prévisualisations
            files.forEach((file, index) => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Créer la miniature
                    const thumbnail = document.createElement('div');
                    thumbnail.className = 'thumbnail-container';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = `Photo ${index + 1}`;
                    
                    const overlay = document.createElement('div');
                    overlay.className = 'overlay';
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-btn';
                    removeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>`;
                    removeBtn.onclick = function() {
                        files.splice(index, 1);
                        updatePhotoPreview();
                    };
                    
                    // Badge "Image principale" pour la première photo
                    if (index === 0) {
                        const mainBadge = document.createElement('span');
                        mainBadge.className = 'main-photo-badge';
                        mainBadge.textContent = 'Image principale';
                        thumbnail.appendChild(mainBadge);
                    }
                    
                    thumbnail.appendChild(img);
                    thumbnail.appendChild(overlay);
                    thumbnail.appendChild(removeBtn);
                    photoPreview.appendChild(thumbnail);
                    
                    // Ajouter à la galerie d'aperçu
                    if (index < 5) { // Limiter à 5 dans l'aperçu
                        const galleryItem = document.createElement('div');
                        galleryItem.className = 'flex-shrink-0 w-32 h-20 bg-gray-100 rounded-lg overflow-hidden';
                        
                        const galleryImg = document.createElement('img');
                        galleryImg.src = e.target.result;
                        galleryImg.alt = `Aperçu ${index + 1}`;
                        galleryImg.className = 'w-full h-full object-cover';
                        
                        galleryItem.appendChild(galleryImg);
                        photoGalleryPreview.appendChild(galleryItem);
                    }
                };
                
                reader.readAsDataURL(file);
            });
        }
        
        // Bouton pour ajouter plus de photos
        addMorePhotosButton.addEventListener('click', function() {
            photosInput.click();
        });
        
        // Bouton pour effacer toutes les photos
        clearPhotosButton.addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer toutes les photos ?')) {
                files = [];
                updatePhotoPreview();
                photosInput.value = '';
            }
        });
        
        // Clic sur la zone de drop pour ouvrir le sélecteur de fichiers
        dropzone.addEventListener('click', function() {
            photosInput.click();
        });
        
        // Animation des inputs lors du focus
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-indigo-100', 'ring-opacity-50');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-indigo-100', 'ring-opacity-50');
            });
        });
        
        // Validation du formulaire avant soumission
        const vehicleForm = document.getElementById('vehicleForm');
        const submitButton = document.getElementById('submit-button');
        
        // submitButton.addEventListener('click', function(e) {
        //     if (files.length === 0) {
        //         e.preventDefault();
        //         alert('Veuillez ajouter au moins une photo du véhicule.');
        //         return;
        //     }
            
        //     // Animation du bouton lors de la soumission
        //     submitButton.disabled = true;
        //     submitButton.innerHTML = `
        //         <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        //             <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        //             <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        //         </svg>
        //         Enregistrement en cours...
        //     `;
        // });
    });
</script>
@endsection

