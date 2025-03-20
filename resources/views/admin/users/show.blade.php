@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $user->firstName }} {{ $user->lastName }}</h1>
            <p class="text-gray-600 mt-2">Détails du compte utilisateur</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Status Panel -->
    <div class="bg-white rounded-lg shadow-md mb-6 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Statut du compte</h2>
        
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px] p-4 bg-gray-50 rounded-lg border">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Compte</p>
                        <div class="flex items-center mt-1">
                            @if($user->is_active)
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <p class="font-medium">Actif</p>
                            @else
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <p class="font-medium">Inactif</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($user->is_active)
                            <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-ban mr-1"></i> Désactiver
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.activate', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <i class="fas fa-check-circle mr-1"></i> Activer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex-1 min-w-[250px] p-4 bg-gray-50 rounded-lg border">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Rôle</p>
                        <div class="flex items-center mt-1">
                            @if($user->role_id == 3) <!-- Admin -->
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                                <p class="font-medium">Administrateur</p>
                            @elseif($user->role_id == 2) <!-- Company -->
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                <p class="font-medium">Entreprise</p>
                            @else <!-- User -->
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                <p class="font-medium">Utilisateur</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-1 min-w-[250px] p-4 bg-gray-50 rounded-lg border">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Date d'inscription</p>
                        <p class="font-medium mt-1">{{ $user->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Information -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Informations personnelles</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-center mb-6">
                        @if($user->avatar)
                            <img class="h-32 w-32 rounded-full object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->firstName }}">
                        @else
                            <div class="h-32 w-32 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-800 font-bold text-4xl">{{ substr($user->firstName, 0, 1) }}{{ substr($user->lastName, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Nom complet</p>
                            <p class="font-medium">{{ $user->firstName }} {{ $user->lastName }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Téléphone</p>
                            <p class="font-medium">{{ $user->phone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="md:col-span-2">
            @if($user->role_id == 2 && $user->company)
                <!-- Company Information -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h2 class="text-xl font-semibold text-gray-800">Informations de l'entreprise</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500">Nom de l'entreprise</p>
                                <p class="font-medium">{{ $user->company->company_name }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Statut de validation</p>
                                @if($user->company->is_validated)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Validée
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        En attente
                                    </span>
                                @endif
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Adresse</p>
                                <p class="font-medium">{{ $user->company->address }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Documents légaux</p>
                                @if($user->company->legal_documents)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Documents fournis
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Documents manquants
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('admin.companies.show', $user->company->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-building mr-2"></i> Voir détails de l'entreprise
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Activity Section -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Activité récente</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Placeholder for activity - can be replaced with actual data -->
                        <div class="flex">
                            <div class="mr-4 flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">Création du compte</p>
                            <p class="text-sm text-gray-500">{{ $user->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>

                    <!-- Placeholder for last login - can be implemented with actual data -->
                    <div class="flex">
                        <div class="mr-4 flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-lock text-gray-500"></i>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">Dernière connexion</p>
                            <p class="text-sm text-gray-500">Non disponible</p>
                        </div>
                    </div>

                    <!-- Placeholder for reservations - can be implemented with actual data -->
                    <div class="flex">
                        <div class="mr-4 flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-gray-500"></i>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">Réservations</p>
                            <p class="text-sm text-gray-500">Aucune réservation pour le moment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection