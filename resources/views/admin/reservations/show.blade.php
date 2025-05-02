@extends('layouts.admin')

@section('content')
<div class="px-6 py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="mb-6">
        <a href="{{ route('admin.reservations.index') }}" class="group flex items-center text-gray-600 hover:text-yellow-600 transition-all duration-300">
            <span class="flex items-center justify-center w-8 h-8 mr-2 rounded-full bg-white shadow-sm border border-gray-200 group-hover:bg-yellow-50 group-hover:border-yellow-200 transition-all duration-300">
                <i class="fas fa-arrow-left transform group-hover:-translate-x-1 transition-transform duration-200"></i>
            </span>
            <span class="font-medium group-hover:underline">Retour à la liste des réservations</span>
        </a>
    </div>
    
    <!-- Reservation Header - High-end styling -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100 transform transition-all duration-300 hover:shadow-xl">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50 via-white to-gray-50">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <div class="w-12 h-12 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-xl mr-3 shadow-sm border border-yellow-200">
                    <i class="fas fa-receipt text-lg"></i>
                </div>
                <span>Réservation <span class="text-yellow-600">#{{ $reservation->id }}</span></span>
            </h2>
            <div>
                @switch($reservation->status)
                    @case('pending')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-50 text-yellow-800 border border-yellow-200 shadow-sm relative overflow-hidden">
                            <span class="absolute inset-0 bg-yellow-100 opacity-50 animate-pulse"></span>
                            <i class="fas fa-clock mr-2 relative z-10"></i> 
                            <span class="relative z-10">En attente</span>
                        </span>
                        @break
                    @case('confirmed')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-50 text-green-800 border border-green-200 shadow-sm">
                            <i class="fas fa-check mr-2"></i> Confirmée
                        </span>
                        @break
                    @case('completed')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-50 text-blue-800 border border-blue-200 shadow-sm">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-ping absolute"></span>
                            <i class="fas fa-flag-checkered mr-2"></i> Terminée
                        </span>
                        @break
                    @case('cancelled')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-50 text-red-800 border border-red-200 shadow-sm">
                            <i class="fas fa-times mr-2"></i> Annulée
                        </span>
                        @break
                    @default
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-50 text-gray-800 border border-gray-200 shadow-sm">
                            {{ $reservation->status }}
                        </span>
                @endswitch
            </div>
        </div>
        
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 bg-white">
            <div class="p-5 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100 shadow-sm transform transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-blue-200 group">
                <p class="text-xs
                 font-semibold text-blue-400 uppercase tracking-wider mb-2">Date de réservation</p>
                <p class="font-semibold text-gray-800 flex items-center">
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 group-hover:bg-blue-200 text-blue-500 mr-3 transition-colors duration-300">
                        <i class="far fa-calendar-alt"></i>
                    </span>
                    {{ $reservation->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            
            <div class="p-5 bg-gradient-to-br from-indigo-50 to-white rounded-xl border border-indigo-100 shadow-sm transform transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-indigo-200 group">
                <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-2">Période de location</p>
                <div class="font-semibold text-gray-800 flex items-center">
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-100 group-hover:bg-indigo-200 text-indigo-500 mr-3 transition-colors duration-300">
                        <i class="fas fa-calendar-day"></i>
                    </span>
                    <div class="flex flex-col sm:flex-row items-center">
                        <span class="bg-white px-2 py-1 rounded-md shadow-sm border border-gray-200 text-sm">
                            {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}
                        </span>
                        <span class="px-2 text-gray-400 mx-1">→</span>
                        <span class="bg-white px-2 py-1 rounded-md shadow-sm border border-gray-200 text-sm">
                            {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="p-5 bg-gradient-to-br from-purple-50 to-white rounded-xl border border-purple-100 shadow-sm transform transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-purple-200 group">
                <p class="text-xs font-semibold text-purple-400 uppercase tracking-wider mb-2">Durée</p>
                <p class="font-semibold text-gray-800 flex items-center">
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-purple-100 group-hover:bg-purple-200 text-purple-500 mr-3 transition-colors duration-300">
                        <i class="far fa-clock"></i>
                    </span>
                    <span class="bg-white px-3 py-1 rounded-md shadow-sm border border-gray-200">
                        {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) }} jours
                    </span>
                </p>
            </div>
            
            <div class="p-5 bg-gradient-to-br from-yellow-50 to-white rounded-xl border border-yellow-100 shadow-sm transform transition-all duration-300 hover:shadow-md hover:-translate-y-1 hover:border-yellow-200 group">
                <p class="text-xs font-semibold text-yellow-500 uppercase tracking-wider mb-2">Total</p>
                <p class="font-bold text-gray-800 flex items-center">
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-yellow-100 group-hover:bg-yellow-200 text-yellow-500 mr-3 transition-colors duration-300">
                        <i class="fas fa-euro-sign"></i>
                    </span>
                    <span class="text-lg">{{ number_format($reservation->total_price, 2) }} €</span>
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Client Information - Luxe styling -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 via-white to-blue-50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 rounded-xl mr-3 shadow-sm border border-blue-100">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        Informations client
                    </h3>
                </div>
                
                @if($reservation->user)
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center mb-8 pb-6 border-b border-gray-100">
                            <div class="h-24 w-24 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mr-6 flex-shrink-0 mb-4 sm:mb-0 shadow-lg">
                                @if($reservation->user->avatar)
                                    <img src="{{ Storage::url($reservation->user->avatar) }}" alt="{{ $reservation->user->firstName }}" class="h-24 w-24 rounded-xl object-cover">
                                @else
                                    <span class="text-2xl font-bold text-white">
                                        {{ substr($reservation->user->firstName ?? '', 0, 1) }}{{ substr($reservation->user->lastName ?? '', 0, 1) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800 flex items-center">
                                    {{ $reservation->user->firstName }} {{ $reservation->user->lastName }}
                                    @if(isset($reservation->user->verified) && $reservation->user->verified)
                                        <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Vérifié
                                        </span>
                                    @endif
                                </h4>
                                <div class="flex items-center mt-2 text-gray-600">
                                    <i class="fas fa-envelope text-blue-400 mr-2"></i>
                                    <a href="mailto:{{ $reservation->user->email }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                        {{ $reservation->user->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($reservation->user->phone)
                                <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-100 transition-all duration-300 hover:shadow-md group">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Téléphone</p>
                                    <p class="font-semibold flex items-center">
                                        <span class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 group-hover:bg-blue-200 text-blue-500 mr-3 transition-colors duration-300">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <a href="tel:{{ $reservation->user->phone }}" class="text-gray-800 hover:text-blue-600 transition-colors duration-200">
                                            {{ $reservation->user->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-100 transition-all duration-300 hover:shadow-md group">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Client depuis</p>
                                <p class="font-semibold flex items-center">
                                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 group-hover:bg-blue-200 text-blue-500 mr-3 transition-colors duration-300">
                                        <i class="fas fa-user-clock"></i>
                                    </span>
                                    {{ $reservation->user->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="flex items-center justify-center">
                            <div class="text-center">
                                <div class="h-16 w-16 mx-auto rounded-full bg-yellow-100 flex items-center justify-center mb-3">
                                    <i class="fas fa-user-slash text-yellow-500 text-xl"></i>
                                </div>
                                <p class="text-gray-500">Les informations du client ne sont pas disponibles.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Vehicle Information - Luxe styling -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 via-white to-green-50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 text-green-600 rounded-xl mr-3 shadow-sm border border-green-100">
                            <i class="fas fa-car"></i>
                        </div>
                        Véhicule
                    </h3>
                </div>
                
                @if($reservation->vehicle)
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/3 mb-6 md:mb-0 md:mr-6 flex-shrink-0">
                                @php
                                    $hasImage = false;
                                    $imagePath = '';
                                    
                                    if($reservation->vehicle->photos && $reservation->vehicle->photos->count() > 0) {
                                        $primaryPhoto = $reservation->vehicle->photos->where('is_primary', true)->first();
                                        if (!$primaryPhoto) {
                                            $primaryPhoto = $reservation->vehicle->photos->first();
                                        }
                                        
                                        if ($primaryPhoto) {
                                            $hasImage = true;
                                            $imagePath = $primaryPhoto->path;
                                        }
                                    }
                                @endphp
                                
                                <div class="h-64 rounded-xl overflow-hidden shadow-lg border border-gray-200 group relative">
                                    @if($hasImage)
                                        <img src="{{ Storage::url($imagePath) }}" alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                            <div class="p-4 text-white w-full">
                                                <div class="text-lg font-bold">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</div>
                                                <div class="text-sm opacity-80">{{ $reservation->vehicle->year }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center h-full bg-gradient-to-br from-gray-100 to-gray-200">
                                            <i class="fas fa-car text-6xl text-gray-300"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="md:w-2/3">
                                <h4 class="text-2xl font-bold text-gray-800 mb-4">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</h4>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                                    <div class="flex flex-col items-center text-center p-3 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-100 shadow-sm transform transition hover:-translate-y-1 hover:shadow-md duration-300">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600 mb-2">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 font-medium">Année</span>
                                        <span class="font-bold text-gray-800">{{ $reservation->vehicle->year }}</span>
                                    </div>
                                    
                                    <div class="flex flex-col items-center text-center p-3 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-100 shadow-sm transform transition hover:-translate-y-1 hover:shadow-md duration-300">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-600 mb-2">
                                            <i class="fas fa-gas-pump"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 font-medium">Carburant</span>
                                        <span class="font-bold text-gray-800">{{ $reservation->vehicle->fuel_type }}</span>
                                    </div>
                                    
                                    <div class="flex flex-col items-center text-center p-3 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-100 shadow-sm transform transition hover:-translate-y-1 hover:shadow-md duration-300">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 mb-2">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 font-medium">Boîte</span>
                                        <span class="font-bold text-gray-800">{{ $reservation->vehicle->transmission === 'automatic' ? 'Auto' : 'Manuel' }}</span>
                                    </div>
                                    
                                    <div class="flex flex-col items-center text-center p-3 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-100 shadow-sm transform transition hover:-translate-y-1 hover:shadow-md duration-300">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-600 mb-2">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 font-medium">Places</span>
                                        <span class="font-bold text-gray-800">{{ $reservation->vehicle->seats }}</span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Immatriculation</p>
                                        <p class="font-medium flex items-center">
                                            <i class="fas fa-id-card text-yellow-500 mr-2"></i>
                                            {{ $reservation->vehicle->license_plate }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Entreprise</p>
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-full bg-yellow-100 flex items-center justify-center mr-2">
                                                <span class="text-xs font-medium text-yellow-700">
                                                    {{ substr($reservation->vehicle->company->company_name ?? '', 0, 1) }}
                                                </span>
                                            </div>
                                            <p class="font-medium">{{ $reservation->vehicle->company->company_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="flex items-center justify-center">
                            <div class="text-center">
                                <div class="h-16 w-16 mx-auto rounded-full bg-yellow-100 flex items-center justify-center mb-3">
                                    <i class="fas fa-car-crash text-yellow-500 text-xl"></i>
                                </div>
                                <p class="text-gray-500">Les informations du véhicule ne sont pas disponibles.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Notes section only if exists -->
            @if(isset($reservation->notes) && !empty($reservation->notes))
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 via-white to-yellow-50">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-yellow-100 to-yellow-200 text-yellow-600 rounded-xl mr-3 shadow-sm border border-yellow-100">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            Notes
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-yellow-400">
                            <p class="text-gray-700 italic">{{ $reservation->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Right Column -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Reservation Summary - Luxe styling -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 via-white to-yellow-50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-yellow-100 to-yellow-200 text-yellow-600 rounded-xl mr-3 shadow-sm border border-yellow-100">
                            <i class="fas fa-receipt"></i>
                        </div>
                        Résumé de la réservation
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-xl mb-3 hover:bg-gray-100 transition-colors duration-200">
                        <span class="text-gray-600">Prix par jour</span>
                        <span class="font-bold text-gray-800">{{ number_format($reservation->vehicle->price_per_day ?? 0, 2) }} €</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-xl mb-3 hover:bg-gray-100 transition-colors duration-200">
                        <span class="text-gray-600">Durée</span>
                        <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) }} jours</span>
                    </div>
                    
                    @if(isset($reservation->extra_options) && is_array($reservation->extra_options))
                        @foreach($reservation->extra_options as $option)
                            <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-xl mb-3 hover:bg-gray-100 transition-colors duration-200">
                                <span class="text-gray-600">{{ $option['name'] ?? 'Option' }}</span>
                                <span class="font-bold text-gray-800">{{ number_format($option['price'] ?? 0, 2) }} €</span>
                            </div>
                        @endforeach
                    @endif
                    
                    @if($reservation->discount_amount > 0)
                        <div class="flex justify-between items-center py-3 px-4 bg-green-50 rounded-xl mb-3 text-green-700 border border-green-100">
                            <span class="flex items-center">
                                <i class="fas fa-tag mr-2"></i> Réduction
                            </span>
                            <span class="font-bold">-{{ number_format($reservation->discount_amount, 2) }} €</span>
                        </div>
                    @endif
                    
                    <div class="mt-6 p-5 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl border border-yellow-200 shadow-sm">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold text-gray-700">Total</span>
                            <span class="text-xl font-bold text-yellow-600">{{ number_format($reservation->total_price, 2) }} €</span>
                        </div>
                        
                        @if($reservation->payment_status === 'paid')
                            <div class="flex justify-end mt-2">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                    <i class="fas fa-check-circle mr-1"></i> Payé
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Payment Information section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 via-white to-green-50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 text-green-600 rounded-xl mr-3 shadow-sm border border-green-100">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        Informations de paiement
                    </h3>
                </div>
                
                <div class="p-6">
                    @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']) && $reservation->payment_method)
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                                    <i class="fas fa-check-circle h-6 w-6 text-green-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-green-800">Paiement Effectué</h3>
                                    <p class="text-green-700">Le paiement du client a été traité avec succès.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <h4 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200">Détails du paiement</h4>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-500">Méthode</p>
                                        <p class="font-medium">
                                            @if($reservation->payment_method == 'paypal')
                                                <span class="inline-flex items-center bg-blue-100 text-blue-800 px-2 py-1 rounded-md">
                                                    <i class="fab fa-paypal mr-1.5"></i> PayPal
                                                </span>
                                            @elseif($reservation->payment_method == 'card')
                                                <span class="inline-flex items-center bg-gray-100 text-gray-800 px-2 py-1 rounded-md">
                                                    <i class="fas fa-credit-card mr-1.5"></i> Carte bancaire
                                                </span>
                                            @else
                                                {{ ucfirst($reservation->payment_method) }}
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-500">Date</p>
                                        <p class="font-medium">{{ $reservation->payment_date ? \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
                                    </div>
                                    
                                    @if($reservation->transaction_id)
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm text-gray-500">Transaction ID</p>
                                            <p class="font-medium font-mono text-sm">{{ $reservation->transaction_id }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($reservation->payer_id)
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm text-gray-500">Payer ID</p>
                                            <p class="font-medium font-mono text-sm">{{ $reservation->payer_id }}</p>
                                        </div>
                                    @endif
                                    
                                    <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-sm text-gray-500">Montant payé</p>
                                        <p class="text-lg font-bold text-green-600">{{ number_format($reservation->amount_paid ?? $reservation->total_price, 2) }} €</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    @elseif(in_array($reservation->status, ['pending', 'payment_pending']))
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-100 rounded-full p-2">
                                    <i class="fas fa-clock h-6 w-6 text-yellow-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-yellow-800">Paiement En Attente</h3>
                                    <p class="text-yellow-700">Le client n'a pas encore finalisé le paiement de cette réservation.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <h4 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200">État du paiement</h4>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Statut</p>
                                <p class="font-medium text-yellow-600">En attente de paiement</p>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-500 mb-1">Montant dû</p>
                                <p class="text-xl font-bold text-gray-800">{{ number_format($reservation->total_price, 2) }} €</p>
                            </div>
                        </div>
                    
                    @elseif($reservation->status === 'canceled')
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                                    <i class="fas fa-times h-6 w-6 text-red-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-red-800">Réservation Annulée</h3>
                                    <p class="text-red-700">Cette réservation a été annulée {{ isset($reservation->canceled_at) ? 'le ' . \Carbon\Carbon::parse($reservation->canceled_at)->format('d/m/Y') : '' }}.</p>
                                </div>
                            </div>
                            
                            @if(isset($reservation->cancellation_reason) && $reservation->cancellation_reason)
                                <div class="mt-4 p-3 bg-white rounded-lg border border-red-100">
                                    <p class="font-medium text-sm text-red-800 mb-1">Motif d'annulation :</p>
                                    <p class="text-red-700">{{ $reservation->cancellation_reason }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Review Information section -->
            @if(isset($reservation->reviews) && $reservation->reviews->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 via-white to-yellow-50">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-yellow-100 to-yellow-200 text-yellow-600 rounded-xl mr-3 shadow-sm border border-yellow-100">
                                <i class="fas fa-star"></i>
                            </div>
                            Avis client
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @foreach($reservation->reviews as $review)
                            <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded-lg border-l-4 border-yellow-300">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Enhanced animations and effects */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(30px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    .animate-spin {
        animation: spin 2s linear infinite;
    }
    
    .animate-ping {
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
    
    @keyframes ping {
        75%, 100% { transform: scale(2); opacity: 0; }
    }
    
    /* Card and container animations */
    .card-appear {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    .slide-in {
        animation: slideInRight 0.5s ease-out forwards;
    }
    
    /* Improved scrollbar styling */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 8px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 8px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Tag & badge better styling */
    .badge {
        @apply inline-flex items-center rounded-full text-xs font-medium;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    /* Gradient text for emphasis */
    .gradient-text {
        @apply font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-yellow-600;
    }
    
    /* Glass effect for important elements */
    .glass-effect {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
</style>
@endpush
@endsection
