@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $company->company_name }}</h1>
            <p class="text-gray-600 mt-2">Détails de l'entreprise et documents</p>
        </div>
        <div>
            <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
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
                        <p class="text-sm text-gray-500">Validation</p>
                        <div class="flex items-center mt-1">
                            @if($company->is_validated)
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <p class="font-medium">Validée</p>
                            @else
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                <p class="font-medium">En attente</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if(!$company->is_validated)
                            <form action="{{ route('admin.companies.validate', $company->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <i class="fas fa-check-circle mr-1"></i> Valider
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex-1 min-w-[250px] p-4 bg-gray-50 rounded-lg border">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Compte</p>
                        <div class="flex items-center mt-1">
                            @if($company->user->is_active)
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                <p class="font-medium">Actif</p>
                            @else
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <p class="font-medium">Suspendu</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($company->user->is_active)
                            <form action="{{ route('admin.companies.suspend', $company->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-ban mr-1"></i> Suspendre
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.companies.reactivate', $company->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-redo mr-1"></i> Réactiver
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex-1 min-w-[250px] p-4 bg-gray-50 rounded-lg border">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Documents</p>
                        <div class="flex items-center mt-1">
                            @if($company->legal_documents)
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <p class="font-medium">Documents fournis</p>
                            @else
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <p class="font-medium">Documents manquants</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Company Information and Documents -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Company Information -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Informations</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Nom de l'entreprise</p>
                            <p class="font-medium">{{ $company->company_name }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Adresse</p>
                            <p class="font-medium">{{ $company->address }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Ville</p>
                            <p class="font-medium">{{ $company->city }}</p>
                        </div>
                        
                        <div class="pt-4 border-t">
                            <p class="text-sm text-gray-500">Contact</p>
                            <p class="font-medium">{{ $company->user->firstName }} {{ $company->user->lastName }}</p>
                            <p class="text-sm">{{ $company->user->email }}</p>
                            <p class="text-sm">{{ $company->user->phone ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="pt-4 border-t">
                            <p class="text-sm text-gray-500">Date d'inscription</p>
                            <p class="font-medium">{{ $company->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Legal Documents -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Documents légaux</h2>
                </div>
                
                @if($company->legal_documents)
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                                $documents = json_decode($company->legal_documents, true);
                            @endphp
                            
                            @if(is_array($documents))
                                @foreach($documents as $key => $path)
                                    <div class="border rounded-lg overflow-hidden">
                                        <div class="px-4 py-2 bg-gray-50 border-b">
                                            <h3 class="font-medium">
                                                @switch($key)
                                                    @case('registre_commerce')
                                                        Registre du Commerce
                                                        @break
                                                    @case('carte_fiscale')
                                                        Carte Fiscale
                                                        @break
                                                    @case('cnas_casnos')
                                                        CNAS/CASNOS
                                                        @break
                                                    @case('autorisation_exploitation')
                                                        Autorisation d'Exploitation
                                                        @break
                                                    @case('contrat_location')
                                                        Contrat de Location
                                                        @break
                                                    @case('assurance_entreprise')
                                                        Assurance de l'Entreprise
                                                        @break
                                                    @default
                                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                @endswitch
                                            </h3>
                                        </div>
                                        <div class="p-4">
                                            <div class="mb-3">
                                                @php
                                                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                                                @endphp
                                                
                                                @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ Storage::url($path) }}" alt="{{ $key }}" class="max-h-40 mx-auto">
                                                @else
                                                    <div class="flex items-center justify-center h-40 bg-gray-100 rounded-lg">
                                                        <i class="fas fa-file-pdf text-4xl text-red-500"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex justify-center">
                                                <a href="{{ Storage::url($path) }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                    <i class="fas fa-eye mr-2"></i> Voir
                                                </a>
                                                <a href="{{ Storage::url($path) }}" download class="ml-3 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                    <i class="fas fa-download mr-2"></i> Télécharger
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-span-2">
                                    <div class="bg-yellow-50 p-4 rounded-lg">
                                        <p class="text-yellow-700">Format de document non valide. Veuillez contacter le support technique.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Documents manquants</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>
                                            L'entreprise n'a pas encore fourni les documents légaux requis pour la validation du compte.
                                        </p>
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
@endsection