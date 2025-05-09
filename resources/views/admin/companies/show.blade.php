@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center">
                    <div class="h-16 w-16 flex-shrink-0 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <i class="fas fa-building text-white text-3xl"></i>
                    </div>
                    <div class="ml-5">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $company->company_name }}</h1>
                        <div class="mt-1 flex flex-wrap items-center text-sm text-blue-100">
                            <span class="flex items-center mr-3">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $company->city }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-1"></i> Membre depuis {{ $company->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm hover:bg-white/20 border border-white/20 text-white text-sm font-medium rounded-lg transition-all">
                        <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
                    </a>
                    
                    @if($company->user->is_active)
                        <form action="{{ route('admin.companies.suspend', $company->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-all">
                                <i class="fas fa-ban mr-2"></i> Suspendre
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.companies.reactivate', $company->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-all">
                                <i class="fas fa-check-circle mr-2"></i> Réactiver
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x">
            <div class="p-6 flex items-center">
                <div class="rounded-full p-3 {{ $company->is_validated ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                    <i class="fas {{ $company->is_validated ? 'fa-check' : 'fa-hourglass-half' }} text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Statut</p>
                    <p class="text-gray-900 font-medium">
                        @if($company->is_validated)
                            Validée
                        @else
                            En attente de validation
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="p-6 flex items-center">
                <div class="rounded-full p-3 {{ $company->user->is_active ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600' }}">
                    <i class="fas {{ $company->user->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Compte</p>
                    <p class="text-gray-900 font-medium">
                        @if($company->user->is_active)
                            Actif
                        @else
                            Suspendu
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="p-6 flex items-center">
                <div class="rounded-full p-3 {{ $company->legal_documents ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    <i class="fas {{ $company->legal_documents ? 'fa-file-alt' : 'fa-file-excel' }} text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Documents</p>
                    <p class="text-gray-900 font-medium">
                        @if($company->legal_documents)
                            Fournis
                        @else
                            Manquants
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow animate-fade-in-down" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.style.display='none'" class="ml-auto text-green-500 hover:text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(!$company->is_validated)
        <div class="mb-6 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-yellow-200 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-yellow-800">Entreprise en attente de validation</h3>
                        <p class="mt-1 text-sm text-yellow-700">
                            Cette entreprise a soumis sa demande et attend votre validation pour commencer à opérer sur la plateforme.
                        </p>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0">
                    <form action="{{ route('admin.companies.validate', $company->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <i class="fas fa-check-circle mr-2"></i> Valider cette entreprise
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-500 hover:shadow-lg">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-info-circle mr-2 text-gray-500"></i> Informations
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-5">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nom de l'entreprise</p>
                        <p class="mt-1 text-gray-900">{{ $company->company_name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Adresse</p>
                        <p class="mt-1 text-gray-900">{{ $company->address }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Ville</p>
                        <p class="mt-1 text-gray-900">{{ $company->city }}</p>
                    </div>
                    
                    <hr class="border-gray-200">
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Responsable</p>
                        <div class="mt-2 flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                @if($company->user->avatar)
                                    <img src="{{ Storage::url($company->user->avatar) }}" alt="{{ $company->user->firstName }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <span class="text-blue-600 font-medium">{{ substr($company->user->firstName, 0, 1) }}{{ substr($company->user->lastName, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-gray-900">{{ $company->user->firstName }} {{ $company->user->lastName }}</p>
                                <p class="text-xs text-gray-500">{{ $company->user->email }}</p>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-phone-alt text-gray-400 mr-1"></i> {{ $company->user->phone ?? 'Non renseigné' }}
                        </p>
                    </div>
                    
                    <hr class="border-gray-200">
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Statistiques</p>
                        <div class="mt-2 grid grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg text-center">
                                <p class="text-2xl font-bold text-blue-600">{{ $company->vehicles->count() }}</p>
                                <p class="text-xs text-gray-500">Véhicules</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg text-center">
                                <p class="text-2xl font-bold text-green-600">{{ $company->reservations->count() }}</p>
                                <p class="text-xs text-gray-500">Réservations</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg text-center">
                                <p class="text-2xl font-bold text-purple-600">{{ (int) $company->created_at->diffInDays(now()) }}</p>
                                <p class="text-xs text-gray-500">Jours</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-3">
                        <a href="{{ route('admin.users.show', $company->user->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                            <span>Voir le profil utilisateur</span>
                            <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Legal Documents -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-500 hover:shadow-lg">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-file-alt mr-2 text-gray-500"></i> Documents légaux
                    </h2>
                </div>
                
                @if($company->legal_documents)
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                                $documents = json_decode($company->legal_documents, true);
                            @endphp
                            
                            @if(is_array($documents))
                                @foreach($documents as $key => $path)
                                    <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
                                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 border-b border-gray-200">
                                            <h3 class="font-medium text-gray-800">
                                                @switch($key)
                                                    @case('registre_commerce')
                                                        <i class="fas fa-file-contract mr-2 text-blue-500"></i> Registre du Commerce
                                                        @break
                                                    @case('carte_fiscale')
                                                        <i class="fas fa-file-invoice mr-2 text-red-500"></i> Carte Fiscale
                                                        @break
                                                    @case('cnas_casnos')
                                                        <i class="fas fa-file-medical mr-2 text-green-500"></i> CNAS/CASNOS
                                                        @break
                                                    @case('autorisation_exploitation')
                                                        <i class="fas fa-file-signature mr-2 text-purple-500"></i> Autorisation d'Exploitation
                                                        @break
                                                    @case('contrat_location')
                                                        <i class="fas fa-file-alt mr-2 text-yellow-500"></i> Contrat de Location
                                                        @break
                                                    @case('assurance_entreprise')
                                                        <i class="fas fa-shield-alt mr-2 text-blue-500"></i> Assurance de l'Entreprise
                                                        @break
                                                    @default
                                                        <i class="fas fa-file mr-2 text-gray-500"></i> {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                @endswitch
                                            </h3>
                                        </div>
                                        <div class="p-4">
                                            <div class="mb-3 bg-gray-100 rounded-lg overflow-hidden">
                                                @php
                                                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                                                @endphp
                                                
                                                @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                                    <a href="{{ Storage::url($path) }}" target="_blank">
                                                        <img src="{{ Storage::url($path) }}" alt="{{ $key }}" class="h-48 w-full object-cover hover:opacity-90 transition-opacity">
                                                    </a>
                                                @else
                                                    <div class="flex flex-col items-center justify-center h-48 bg-gray-200 hover:bg-gray-300 transition-colors">
                                                        <i class="fas fa-file-pdf text-5xl text-red-500 mb-2"></i>
                                                        <p class="text-sm text-gray-600">{{ strtoupper($extension) }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex justify-between">
                                                <a href="{{ Storage::url($path) }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                    <i class="fas fa-eye mr-2 text-blue-500"></i> Voir
                                                </a>
                                                <a href="{{ Storage::url($path) }}" download class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                    <i class="fas fa-download mr-2 text-green-500"></i> Télécharger
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-span-2">
                                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-yellow-800">Format de document non valide</h3>
                                                <div class="mt-2 text-sm text-yellow-700">
                                                    <p>Le format des documents n'est pas valide. Veuillez contacter le support technique pour résoudre ce problème.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                                </div>
                                <div class="ml-5">
                                    <h3 class="text-lg font-medium text-yellow-800">Documents manquants</h3>
                                    <div class="mt-2 text-yellow-700">
                                        <p>L'entreprise n'a pas encore fourni les documents légaux requis pour la validation du compte.</p>
                                        <p class="mt-2">Vous pouvez contacter l'entreprise pour demander les documents nécessaires.</p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="mailto:{{ $company->user->email }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            <i class="fas fa-envelope mr-2"></i> Contacter par email
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.3s ease-in-out;
    }
</style>
@endsection