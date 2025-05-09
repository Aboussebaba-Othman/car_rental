@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section with Gradient Background -->
    <div class="rounded-xl overflow-hidden shadow-xl mb-8 bg-gradient-to-r from-blue-500 to-indigo-600">
        <div class="p-6 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-5">
                    <div class="h-20 w-20 rounded-full bg-white/20 backdrop-blur-sm p-1 shadow-inner">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->firstName }}" class="h-full w-full object-cover rounded-full">
                        @else
                            <div class="h-full w-full rounded-full bg-white/30 flex items-center justify-center">
                                <span class="text-white font-bold text-2xl">{{ substr($user->firstName, 0, 1) }}{{ substr($user->lastName, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center space-x-3">
                            <h1 class="text-3xl font-bold">{{ $user->firstName }} {{ $user->lastName }}</h1>
                            @if($user->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-1.5"></div>
                                    Actif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-1.5"></div>
                                    Inactif
                                </span>
                            @endif
                        </div>
                        <p class="mt-1 text-blue-100">
                            @if($user->role_id == 3) <!-- Admin -->
                                <span class="inline-flex items-center">
                                    <i class="fas fa-shield-alt mr-1"></i> Administrateur
                                </span>
                            @elseif($user->role_id == 2) <!-- Company -->
                                <span class="inline-flex items-center">
                                    <i class="fas fa-building mr-1"></i> Entreprise
                                </span>
                            @else <!-- User -->
                                <span class="inline-flex items-center">
                                    <i class="fas fa-user mr-1"></i> Utilisateur
                                </span>
                            @endif
                            · Membre depuis {{ $user->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
                
                <div class="mt-4 md:mt-0">
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm hover:bg-white/20 border border-white/20 text-white text-sm font-medium rounded-lg transition-all">
                            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
                        </a>
                        
                        @if($user->is_active)
                            <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-all">
                                    <i class="fas fa-ban mr-2"></i> Désactiver
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.activate', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-all">
                                    <i class="fas fa-check-circle mr-2"></i> Activer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="flex flex-col items-center p-4 bg-white/10 backdrop-blur-sm rounded-lg border border-white/10">
                    <p class="text-sm text-blue-100">Email</p>
                    <p class="font-medium mt-1">{{ $user->email }}</p>
                </div>
                
                <div class="flex flex-col items-center p-4 bg-white/10 backdrop-blur-sm rounded-lg border border-white/10">
                    <p class="text-sm text-blue-100">Téléphone</p>
                    <p class="font-medium mt-1">{{ $user->phone ?? 'Non renseigné' }}</p>
                </div>
                
                <div class="flex flex-col items-center p-4 bg-white/10 backdrop-blur-sm rounded-lg border border-white/10">
                    <p class="text-sm text-blue-100">Email vérifié</p>
                    @if($user->email_verified_at)
                        <p class="font-medium mt-1 text-green-200"><i class="fas fa-check-circle mr-1"></i> {{ Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y') }}</p>
                    @else
                        <p class="font-medium mt-1 text-red-200"><i class="fas fa-times-circle mr-1"></i> Non vérifié</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm animate-fade-in" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-1">
            <!-- Usage Statistics - Only for non-company users -->
            @if($user->role_id != 2)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-all">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Statistiques d'utilisation</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Réservations complétées</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ isset($user->reservations) ? $user->reservations->where('status', 'completed')->count() : 0 }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ isset($user->reservations) && $user->reservations->count() > 0 ? ($user->reservations->where('status', 'completed')->count() / $user->reservations->count() * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Réservations annulées</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ isset($user->reservations) ? $user->reservations->whereIn('status', ['canceled', 'cancelled'])->count() : 0 }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: {{ isset($user->reservations) && $user->reservations->count() > 0 ? ($user->reservations->whereIn('status', ['canceled', 'cancelled'])->count() / $user->reservations->count() * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Réservations en attente</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ isset($user->reservations) ? $user->reservations->where('status', 'pending')->count() : 0 }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ isset($user->reservations) && $user->reservations->count() > 0 ? ($user->reservations->where('status', 'pending')->count() / $user->reservations->count() * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Dernière activité</span>
                                <span class="text-sm font-medium text-gray-700">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Account Activity Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-scroll border border-gray-100 hover:shadow-md transition-all {{ $user->role_id != 2 ? 'mt-6' : '' }}">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Activité du compte</h2>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            <!-- Account Creation -->
                            <li>
                                <div class="relative pb-8">
                                    @if($user->email_verified_at || ($user->role_id == 2 && $user->company) || (isset($user->reservations) && $user->reservations->count() > 0))
                                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div class="h-8 w-8 bg-blue-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                                    <i class="fas fa-user-plus text-white text-sm"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">Création du compte</p>
                                                <p class="mt-0.5 text-sm text-gray-500">L'utilisateur a créé son compte</p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-600">
                                                <time datetime="{{ $user->created_at->format('Y-m-d') }}">{{ $user->created_at->format('d/m/Y à H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Email Verification -->
                            @if($user->email_verified_at)
                            <li>
                                <div class="relative pb-8">
                                    @if(($user->role_id == 2 && $user->company) || (isset($user->reservations) && $user->reservations->count() > 0))
                                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                                    <i class="fas fa-envelope-open-text text-white text-sm"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">Adresse email vérifiée</p>
                                                <p class="mt-0.5 text-sm text-gray-500">L'adresse email a été vérifiée</p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-600">
                                                <time datetime="{{ Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d') }}">
                                                    {{ Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y à H:i') }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            
                            <!-- Company Registration -->
                            @if($user->role_id == 2 && $user->company)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$user->company->is_validated || (isset($user->reservations) && $user->reservations->count() > 0))
                                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div class="h-8 w-8 bg-blue-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                                    <i class="fas fa-building text-white text-sm"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">Enregistrement de l'entreprise</p>
                                                <p class="mt-0.5 text-sm text-gray-500">A enregistré l'entreprise "{{ $user->company->company_name }}"</p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-600">
                                                <time datetime="{{ $user->company->created_at->format('Y-m-d') }}">
                                                    {{ $user->company->created_at->format('d/m/Y à H:i') }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Company Validation -->
                            @if($user->company->is_validated)
                            <li>
                                <div class="relative pb-8">
                                    @if(isset($user->reservations) && $user->reservations->count() > 0)
                                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                                    <i class="fas fa-check-circle text-white text-sm"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">Validation de l'entreprise</p>
                                                <p class="mt-0.5 text-sm text-gray-500">L'entreprise a été validée par l'administration</p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-600">
                                                <time datetime="{{ $user->company->updated_at->format('Y-m-d') }}">
                                                    {{ $user->company->updated_at->format('d/m/Y') }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @else
                            <li>
                                <div class="relative pb-8">
                                    @if(isset($user->reservations) && $user->reservations->count() > 0)
                                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div class="h-8 w-8 bg-yellow-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                                    <i class="fas fa-clock text-white text-sm"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">En attente de validation</p>
                                                <p class="mt-0.5 text-sm text-gray-500">L'entreprise est en attente de validation par l'administration</p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-600">
                                                <span>En cours</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            @endif
                            
                            <!-- First Reservation -->
                            @if(isset($user->reservations) && $user->reservations->count() > 0)
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div class="h-8 w-8 bg-indigo-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                                    <i class="fas fa-calendar-alt text-white text-sm"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">Première réservation effectuée</p>
                                                <p class="mt-0.5 text-sm text-gray-500">L'utilisateur a effectué sa première réservation</p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-600">
                                                <time datetime="{{ $user->reservations->sortBy('created_at')->first()->created_at->format('Y-m-d') }}">
                                                    {{ $user->reservations->sortBy('created_at')->first()->created_at->format('d/m/Y') }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="lg:col-span-2 space-y-6">
            @if($user->role_id == 2 && $user->company)
                <!-- Company Information -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-all">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-white">Informations entreprise</h2>
                            <a href="{{ route('admin.companies.show', $user->company->id) }}" class="text-xs bg-white/20 hover:bg-white/30 text-white py-1 px-3 rounded-full transition-all flex items-center space-x-1">
                                <span>Voir profil</span>
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-6 pb-6 border-b border-gray-100">
                            <div class="bg-blue-50 p-3 rounded-lg mr-4">
                                <i class="fas fa-building text-blue-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $user->company->company_name }}</h3>
                                <div class="mt-1">
                                    @if($user->company->is_validated)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Validée
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> En attente de validation
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Adresse</p>
                                <div class="mt-1 flex items-start">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-2 mt-1"></i>
                                    <p class="text-gray-800">{{ $user->company->address }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Documents légaux</p>
                                <div class="mt-1">
                                    @if($user->company->legal_documents)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-file-alt mr-1"></i> Documents fournis
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Documents manquants
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Company Stats -->
                        <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 transition-transform hover:transform hover:scale-105">
                                <div class="text-center">
                                    <p class="text-sm font-medium text-blue-800 mb-1">Véhicules</p>
                                    <p class="text-2xl font-bold text-blue-700">{{ $user->company->vehicles->count() }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 transition-transform hover:transform hover:scale-105">
                                <div class="text-center">
                                    <p class="text-sm font-medium text-green-800 mb-1">Réservations</p>
                                    <p class="text-2xl font-bold text-green-700">{{ $user->company->reservations->count() }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 transition-transform hover:transform hover:scale-105">
                                <div class="text-center">
                                    <p class="text-sm font-medium text-purple-800 mb-1">Promotions</p>
                                    <p class="text-2xl font-bold text-purple-700">{{ $user->company->promotions->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Reservations - Only show for non-company users -->
            @if($user->role_id != 2)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-all">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Réservations récentes</h2>
                    </div>
                    <div class="p-6">
                        @if(isset($user->reservations) && $user->reservations->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($user->reservations()->latest()->take(3)->get() as $reservation)
                                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-sm transition-all">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 rounded-md bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-car text-blue-500"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="font-medium text-gray-900">
                                                        @if($reservation->vehicle)
                                                            {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}
                                                        @else
                                                            Véhicule indisponible
                                                        @endif
                                                    </h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-end">
                                                <div class="mb-1">
                                                    @switch($reservation->status)
                                                        @case('pending')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                <i class="fas fa-clock mr-1"></i> En attente
                                                            </span>
                                                            @break
                                                        @case('confirmed')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                <i class="fas fa-check mr-1"></i> Confirmée
                                                            </span>
                                                            @break
                                                        @case('completed')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                <i class="fas fa-flag-checkered mr-1"></i> Terminée
                                                            </span>
                                                            @break
                                                        @case('canceled')
                                                        @case('cancelled')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                <i class="fas fa-times mr-1"></i> Annulée
                                                            </span>
                                                            @break
                                                        @case('payment_pending')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                <i class="fas fa-credit-card mr-1"></i> Paiement en attente
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                {{ ucfirst($reservation->status) }}
                                                            </span>
                                                    @endswitch
                                                </div>
                                                <p class="text-lg font-semibold text-gray-900">{{ number_format($reservation->total_price, 2) }} €</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-200 flex justify-end">
                                            <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Voir les détails →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($user->reservations->count() > 3)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('admin.reservations.index', ['search' => $user->email]) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 border border-transparent rounded-md hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-list-ul mr-2"></i> Voir toutes les réservations
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center p-6 bg-gray-100 rounded-full mb-4 text-gray-500">
                                    <i class="fas fa-calendar-times text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune réservation</h3>
                                <p class="text-gray-500 max-w-md mx-auto">
                                    Cet utilisateur n'a pas encore effectué de réservation.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
</style>
@endsection