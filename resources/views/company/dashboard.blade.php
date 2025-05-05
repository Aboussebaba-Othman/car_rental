@extends('layouts.company')

@section('title', 'Tableau de Bord')
@section('header', 'Tableau de Bord de l\'Entreprise')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Active Vehicles Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Véhicules Actifs</p>
            <p class="text-3xl font-bold text-gray-800">{{ $company->vehicles->where('is_active', true)->count() ?? 0 }}</p>
        </div>
        <div class="bg-blue-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
    </div>
    
    <!-- Pending Reservations Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Réservations en Attente</p>
            <p class="text-3xl font-bold text-gray-800">{{ $company->reservations->where('status', 'pending')->count() ?? 0 }}</p>
        </div>
        <div class="bg-yellow-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    
    <!-- Active Promotions Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Promotions Actives</p>
            <p class="text-3xl font-bold text-gray-800">{{ $company->promotions->where('is_active', true)->count() ?? 0 }}</p>
        </div>
        <div class="bg-green-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    
    <!-- Total Revenue Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Revenu Total</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($company->reservations->where('status', 'completed')->sum('total_price'), 2) ?? 0 }} €</p>
        </div>
        <div class="bg-purple-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Reservations -->
    <div class="bg-white rounded-lg shadow col-span-2">
        <div class="px-6 py-4 border-b">
            <h2 class="font-medium text-gray-700">Réservations Récentes</h2>
        </div>
        <div class="p-6">
            @if($company->reservations && $company->reservations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Location
                                </th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Véhicule
                                </th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Client
                                </th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($company->reservations->sortByDesc('created_at')->take(5) as $reservation)
                                <tr>
                                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                                        #{{ $reservation->id }}
                                    </td>
                                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                                        {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}
                                    </td>
                                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                                        {{ $reservation->user->name }}
                                    </td>
                                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                                        {{ $reservation->start_date->format('d/m/Y') }} - {{ $reservation->end_date->format('d/m/Y') }}
                                    </td>
                                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                                        @if($reservation->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @elseif($reservation->status == 'confirmed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmée
                                            </span>
                                        @elseif($reservation->status == 'canceled')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Annulée
                                            </span>
                                        @elseif($reservation->status == 'completed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Terminée
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Voir toutes les réservations</a>
                </div>
            @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-2 text-gray-500">Aucune réservation trouvée.</p>
                    <button class="mt-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ajouter votre premier véhicule
                    </button>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recent Messages and Activity Feed -->
    <div class="space-y-6">
        <!-- Recent Messages -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="font-medium text-gray-700">Messages Récents</h2>
                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">3 Non lus</span>
            </div>
            <div class="p-6">
                @if(isset($messages) && count($messages) > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <li class="py-3">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($message->sender_name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $message->sender_name }}">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $message->sender_name }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ Str::limit($message->content, 30) }}</p>
                                    </div>
                                    <span class="ml-auto text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Voir tous les messages</a>
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <p class="mt-2 text-gray-500">Aucun message trouvé.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Recent Reviews -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="font-medium text-gray-700">Avis Récents</h2>
            </div>
            <div class="p-6">
                @if(isset($reviews) && count($reviews) > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($reviews as $review)
                            <li class="py-3">
                                <div class="flex items-start">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $review->user->name }}">
                                    <div class="ml-3">
                                        <div class="flex items-center">
                                            <p class="text-sm font-medium text-gray-900">{{ $review->user->name }}</p>
                                            <span class="ml-2 flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $review->vehicle->brand }} {{ $review->vehicle->model }}</p>
                                        <p class="mt-1 text-sm text-gray-600">{{ Str::limit($review->comment, 100) }}</p>
                                    </div>
                                    <span class="ml-auto text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Voir tous les avis</a>
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <p class="mt-2 text-gray-500">Pas encore d'avis.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Available & Rented Vehicles Overview -->
<div class="mt-6 bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h2 class="font-medium text-gray-700">Aperçu de l'état des véhicules</h2>
    </div>
    <div class="p-6">
        @if(isset($company->vehicles) && $company->vehicles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Available Vehicles -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Véhicules Disponibles</h3>
                    <div class="space-y-3">
                        @foreach($company->vehicles->where('is_available', true)->take(3) as $vehicle)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-md overflow-hidden">
                                    @if($vehicle->photos->count() > 0)
                                        <img src="{{ asset('storage/' . $vehicle->photos->first()->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h4>
                                        <p class="text-sm font-medium text-gray-900">{{ number_format($vehicle->price_per_day, 2) }} €/jour</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $vehicle->year }} · {{ $vehicle->transmission }} · {{ $vehicle->fuel_type }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Currently Rented Vehicles -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Actuellement Loués</h3>
                    <div class="space-y-3">
                        @php
                            $rentedVehicles = $company->vehicles->filter(function($vehicle) {
                                return $vehicle->reservations->where('status', 'confirmed')
                                    ->where('start_date', '<=', now())
                                    ->where('end_date', '>=', now())
                                    ->count() > 0;
                            })->take(3);
                        @endphp
                        
                        @if($rentedVehicles->count() > 0)
                            @foreach($rentedVehicles as $vehicle)
                                @php
                                    $activeReservation = $vehicle->reservations->where('status', 'confirmed')
                                        ->where('start_date', '<=', now())
                                        ->where('end_date', '>=', now())
                                        ->first();
                                @endphp
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                    <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-md overflow-hidden">
                                        @if($vehicle->photos->count() > 0)
                                            <img src="{{ asset('storage/' . $vehicle->photos->first()->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex justify-between">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h4>
                                            <p class="text-xs text-gray-500">
                                                Retour: {{ $activeReservation->end_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            Loué par: {{ $activeReservation->user->firstName }} {{ $activeReservation->user->lastName }}<br>
                                           
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center justify-center p-6 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-500">Aucun véhicule actuellement loué.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="mt-2 text-gray-500">Aucun véhicule ajouté pour le moment.</p>
                <button class="mt-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ajouter votre premier véhicule
                </button>
            </div>
        @endif
    </div>
</div>
@endsection