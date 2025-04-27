@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tableau de bord</h1>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border-l-4 border-blue-500">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Utilisateurs</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['users'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="{{ $stats['user_change'] >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            @if($stats['user_change'] >= 0)
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            @else
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                            @endif
                        </svg>
                        {{ abs($stats['user_change']) }}%
                    </span>
                </div>
            </div>
            <div class="bg-blue-50 px-5 py-2">
                <a href="{{ route('admin.users.index') }}" class="text-blue-500 text-sm font-medium flex items-center">
                    Voir tous les utilisateurs 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Companies Card -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border-l-4 border-purple-500">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Entreprises</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['companies'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="{{ $stats['company_change'] >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            @if($stats['company_change'] >= 0)
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            @else
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                            @endif
                        </svg>
                        {{ abs($stats['company_change']) }}%
                    </span>
                </div>
            </div>
            <div class="bg-purple-50 px-5 py-2">
                <a href="{{ route('admin.companies.index') }}" class="text-purple-500 text-sm font-medium flex items-center">
                    Voir toutes les entreprises
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Vehicles Card -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border-l-4 border-green-500">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Véhicules</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['vehicles'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3zm0 2h12v.586l3 3V15h-1.05a2.5 2.5 0 00-4.9 0H9a1 1 0 01-1 1v1H4a1 1 0 01-1-1V6z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="{{ $stats['vehicle_change'] >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            @if($stats['vehicle_change'] >= 0)
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            @else
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                            @endif
                        </svg>
                        {{ abs($stats['vehicle_change']) }}%
                    </span>
                </div>
            </div>
            <div class="bg-green-50 px-5 py-2">
                <a href="" class="text-green-500 text-sm font-medium flex items-center">
                    Voir tous les véhicules
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Reservations Card -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border-l-4 border-yellow-500">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Réservations</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['reservations'] ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="{{ $stats['reservation_change'] >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            @if($stats['reservation_change'] >= 0)
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            @else
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                            @endif
                        </svg>
                        {{ abs($stats['reservation_change']) }}%
                    </span>
                </div>
            </div>
            <div class="bg-yellow-50 px-5 py-2">
                <a href="" class="text-yellow-500 text-sm font-medium flex items-center">
                    Voir toutes les réservations
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Top Companies Section - Simplified without charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Companies by Vehicles -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3zm0 2h12v.586l3 3V15h-1.05a2.5 2.5 0 00-4.9 0H9a1 1 0 01-1 1v1H4a1 1 0 01-1-1V6z" />
                    </svg>
                    Top 5 Entreprises par Nombre de Véhicules
                </h2>
                <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-lg">
                    Total: {{ $topCompaniesByVehicles->sum('vehicle_count') }} véhicules
                </span>
            </div>
            
            <div class="bg-white p-4">
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b-2 border-blue-100">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b-2 border-blue-100">Entreprise</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b-2 border-blue-100">Véhicules</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b-2 border-blue-100">%</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $totalVehicles = $topCompaniesByVehicles->sum('vehicle_count'); @endphp
                            @foreach($topCompaniesByVehicles as $index => $company)
                            @php $percentage = $totalVehicles > 0 ? round(($company->vehicle_count / $totalVehicles) * 100) : 0; @endphp
                            <tr class="hover:bg-blue-50 transition-colors duration-200">
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm font-medium text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm font-medium text-gray-800">
                                    <div class="flex items-center">
                                        <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center mr-3 shadow-sm">
                                            <span class="text-white font-bold text-xs">{{ substr($company->company_name, 0, 2) }}</span>
                                        </div>
                                        <span class="hover:text-blue-600 transition-colors">{{ $company->company_name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm text-gray-800 text-right">
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-medium shadow-sm">
                                        {{ $company->vehicle_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm text-right">
                                    <div class="flex items-center justify-end">
                                        <div class="w-24 bg-gray-200 rounded-full h-2.5 mr-2">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-gray-600 font-medium">{{ $percentage }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            @if($topCompaniesByVehicles->count() == 0)
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                    Aucune entreprise avec des véhicules disponible.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Top Companies by Reservations -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    Top 5 Entreprises par Réservations
                </h2>
                <span class="bg-green-600 text-white text-xs px-3 py-1 rounded-lg">
                    Total: {{ $topCompaniesByReservations->sum('reservation_count') }} réservations
                </span>
            </div>
            
            <div class="bg-white p-4">
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b-2 border-green-100">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b-2 border-green-100">Entreprise</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b-2 border-green-100">Réservations</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b-2 border-green-100">%</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $totalReservations = $topCompaniesByReservations->sum('reservation_count'); @endphp
                            @foreach($topCompaniesByReservations as $index => $company)
                            @php $percentage = $totalReservations > 0 ? round(($company->reservation_count / $totalReservations) * 100) : 0; @endphp
                            <tr class="hover:bg-green-50 transition-colors duration-200">
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm font-medium text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm font-medium text-gray-800">
                                    <div class="flex items-center">
                                        <div class="w-9 h-9 rounded-full bg-green-500 flex items-center justify-center mr-3 shadow-sm">
                                            <span class="text-white font-bold text-xs">{{ substr($company->company_name, 0, 2) }}</span>
                                        </div>
                                        <span class="hover:text-green-600 transition-colors">{{ $company->company_name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm text-gray-800 text-right">
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-medium shadow-sm">
                                        {{ $company->reservation_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm text-right">
                                    <div class="flex items-center justify-end">
                                        <div class="w-24 bg-gray-200 rounded-full h-2.5 mr-2">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-gray-600 font-medium">{{ $percentage }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            @if($topCompaniesByReservations->count() == 0)
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                    Aucune entreprise avec des réservations disponible.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reservation Statistics Section - Modern Stats Cards -->
    <div class="mb-8">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                    </svg>
                    Statistiques de Réservation
                </h2>
                <div class="flex items-center space-x-2">
                    <div class="text-xs px-2 py-1 rounded bg-purple-100 text-purple-700">{{ Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
                    <span class="bg-purple-600 text-white text-xs px-3 py-1 rounded-lg">
                        Total: {{ array_sum(array_column($monthlyStats, 'count')) }} réservations
                    </span>
                </div>
            </div>
            
            <div class="bg-white p-5">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    <!-- Stats Cards -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200 shadow-sm hover:shadow transition-all">
                        <p class="text-xs text-blue-700 mb-1 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            Réservations ce mois
                        </p>
                        <div class="flex items-end justify-between">
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $monthlyStats[Carbon\Carbon::now()->month - 1]['count'] ?? 0 }}</p>
                            @if(Carbon\Carbon::now()->month > 1 && isset($monthlyStats[Carbon\Carbon::now()->month - 2]))
                                @php 
                                    $lastMonth = $monthlyStats[Carbon\Carbon::now()->month - 2]['count'] ?? 0;
                                    $thisMonth = $monthlyStats[Carbon\Carbon::now()->month - 1]['count'] ?? 0;
                                    $change = $lastMonth > 0 ? round(($thisMonth - $lastMonth) / $lastMonth * 100) : 0;
                                @endphp
                                <span class="{{ $change >= 0 ? 'text-green-600' : 'text-red-600' }} text-sm font-medium flex items-center">
                                    @if($change >= 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    {{ abs($change) }}%
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- More stat cards -->
                    <!-- ...existing code for the other stat cards... -->
                </div>
                
                <!-- Monthly Summary - Bar representation instead of charts -->
                <div class="mt-6 p-5 bg-gray-50 rounded-lg border border-gray-100">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Réservations par mois</h3>
                    <div class="space-y-2">
                        @php
                            $maxCount = max(array_column($monthlyStats, 'count'));
                        @endphp
                        @foreach($monthlyStats as $index => $month)
                            <div class="flex items-center">
                                <div class="w-20 text-xs text-gray-500">{{ $month['month'] }}</div>
                                <div class="flex-1">
                                    <div class="h-5 relative">
                                        @php $width = $maxCount > 0 ? ($month['count'] / $maxCount) * 100 : 0; @endphp
                                        <div 
                                            class="absolute top-0 left-0 h-full bg-purple-500 rounded-r-sm"
                                            style="width: {{ $width }}%">
                                        </div>
                                        <div class="absolute top-0 left-2 h-full flex items-center text-xs font-medium {{ $width > 30 ? 'text-white' : 'text-gray-700' }}">
                                            {{ $month['count'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Weekly Summary - Bar representation -->
                <div class="mt-4 p-5 bg-gray-50 rounded-lg border border-gray-100">
                    <h3 class="text-md font-medium text-gray-700 mb-4">Réservations par semaine</h3>
                    <div class="space-y-2">
                        @php
                            $maxWeekCount = max(array_column($weeklyStats, 'count'));
                        @endphp
                        @foreach($weeklyStats as $index => $week)
                            <div class="flex items-center">
                                <div class="w-32 text-xs text-gray-500">{{ $week['week'] }}</div>
                                <div class="flex-1">
                                    <div class="h-5 relative">
                                        @php $width = $maxWeekCount > 0 ? ($week['count'] / $maxWeekCount) * 100 : 0; @endphp
                                        <div 
                                            class="absolute top-0 left-0 h-full bg-yellow-500 rounded-r-sm animate-bar"
                                            style="width: {{ $width }}%">
                                        </div>
                                        <div class="absolute top-0 left-2 h-full flex items-center text-xs font-medium {{ $width > 30 ? 'text-white' : 'text-gray-700' }}">
                                            {{ $week['count'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Simple, clean animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .stats-card {
        animation: fadeIn 0.4s ease-out forwards;
    }
    
    /* Progress bar animation */
    @keyframes growWidth {
        from { width: 0; }
        to { width: 100%; }
    }
    
    .animate-bar {
        animation: growWidth 1s ease-out forwards;
    }
</style>
@endpush