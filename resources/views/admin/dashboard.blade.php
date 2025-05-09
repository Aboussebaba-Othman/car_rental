@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tableau de bord</h1>
    
    <!-- Main Stats Cards - Redesigned with gradients and better visual hierarchy -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-md transform transition hover:scale-105 duration-300">
            <div class="absolute right-0 top-0 -mt-4 -mr-16 opacity-30">
                <i class="fas fa-users text-9xl text-white"></i>
            </div>
            <div class="px-6 py-8 relative">
                <div class="text-xs uppercase text-blue-100 tracking-wider mb-1 font-semibold">Utilisateurs</div>
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-white">{{ $stats['users'] }}</div>
                    
                    @if($stats['user_change'] != 0)
                        <div class="ml-3 flex items-center {{ $stats['user_change'] > 0 ? 'text-green-300' : 'text-red-300' }}">
                            <i class="fas fa-{{ $stats['user_change'] > 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                            <span>{{ abs($stats['user_change']) }}%</span>
                        </div>
                    @endif
                </div>
                <div class="mt-4 flex items-center text-blue-100 text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i> Nouveaux en {{ $stats['currentMonthName'] }}: {{ $stats['usersCurrentMonth'] ?? 0 }}
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-xl shadow-md transform transition hover:scale-105 duration-300">
            <div class="absolute right-0 top-0 -mt-4 -mr-16 opacity-30">
                <i class="fas fa-building text-9xl text-white"></i>
            </div>
            <div class="px-6 py-8 relative">
                <div class="text-xs uppercase text-yellow-100 tracking-wider mb-1 font-semibold">Entreprises</div>
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-white">{{ $stats['companies'] }}</div>
                    
                    @if($stats['company_change'] != 0)
                        <div class="ml-3 flex items-center {{ $stats['company_change'] > 0 ? 'text-green-300' : 'text-red-300' }}">
                            <i class="fas fa-{{ $stats['company_change'] > 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                            <span>{{ abs($stats['company_change']) }}%</span>
                        </div>
                    @endif
                </div>
                <div class="mt-4 flex items-center text-yellow-100 text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i> Nouvelles en {{ $stats['currentMonthName'] }}: {{ $stats['companiesCurrentMonth'] ?? 0 }}
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-md transform transition hover:scale-105 duration-300">
            <div class="absolute right-0 top-0 -mt-4 -mr-16 opacity-30">
                <i class="fas fa-car text-9xl text-white"></i>
            </div>
            <div class="px-6 py-8 relative">
                <div class="text-xs uppercase text-green-100 tracking-wider mb-1 font-semibold">Véhicules</div>
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-white">{{ $stats['vehicles'] }}</div>
                    
                    @if($stats['vehicle_change'] != 0)
                        <div class="ml-3 flex items-center {{ $stats['vehicle_change'] > 0 ? 'text-green-300' : 'text-red-300' }}">
                            <i class="fas fa-{{ $stats['vehicle_change'] > 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                            <span>{{ abs($stats['vehicle_change']) }}%</span>
                        </div>
                    @endif
                </div>
                <div class="mt-4 flex items-center text-green-100 text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i> Nouveaux en {{ $stats['currentMonthName'] }}: {{ $stats['vehiclesCurrentMonth'] ?? 0 }}
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-md transform transition hover:scale-105 duration-300">
            <div class="absolute right-0 top-0 -mt-4 -mr-16 opacity-30">
                <i class="fas fa-calendar-check text-9xl text-white"></i>
            </div>
            <div class="px-6 py-8 relative">
                <div class="text-xs uppercase text-purple-100 tracking-wider mb-1 font-semibold">Réservations</div>
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-white">{{ $stats['reservations'] }}</div>
                    
                    @if($stats['reservation_change'] != 0)
                        <div class="ml-3 flex items-center {{ $stats['reservation_change'] > 0 ? 'text-green-300' : 'text-red-300' }}">
                            <i class="fas fa-{{ $stats['reservation_change'] > 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                            <span>{{ abs($stats['reservation_change']) }}%</span>
                        </div>
                    @endif
                </div>
                <div class="mt-4 flex items-center text-purple-100 text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i> Nouvelles en {{ $stats['currentMonthName'] }}: {{ $stats['reservationsCurrentMonth'] ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Summary - Redesigned clean style -->
    <div class="mt-8 p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
        <h3 class="text-lg font-medium text-gray-800 mb-5 flex items-center">
            <i class="fas fa-chart-bar text-blue-600 mr-2"></i> Réservations par mois
        </h3>
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
            @foreach($monthlyStats as $index => $month)
                <div class="p-3 text-center rounded-lg bg-gradient-to-br {{ $month['count'] > 0 ? 'from-blue-50 to-blue-100 border border-blue-200' : 'bg-gray-50 border border-gray-100' }}">
                    <div class="text-sm font-medium text-gray-700">{{ $month['month'] }}</div>
                    <div class="text-xl font-bold {{ $month['count'] > 0 ? 'text-blue-600' : 'text-gray-400' }}">
                        {{ $month['count'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Weekly Summary - Redesigned clean style -->
    <div class="mt-6 p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
        <h3 class="text-lg font-medium text-gray-800 mb-5 flex items-center">
            <i class="fas fa-calendar-week text-indigo-600 mr-2"></i> Réservations par semaine
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @foreach($weeklyStats as $week)
                <div class="flex flex-col p-3 rounded-lg {{ $week['count'] > 0 ? 'bg-gradient-to-br from-indigo-50 to-indigo-100 border border-indigo-200' : 'bg-gray-50 border border-gray-100' }}">
                    <div class="text-xs font-medium text-gray-600 mb-1">{{ $week['week'] }}</div>
                    <div class="text-xl font-bold {{ $week['count'] > 0 ? 'text-indigo-600' : 'text-gray-400' }}">
                        {{ $week['count'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Top Companies Section Styled -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Top Companies By Vehicles -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 flex items-center">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                    Top Entreprises par Véhicules
                </h3>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    @forelse($topCompaniesByVehicles as $index => $company)
                        <li class="flex items-center justify-between p-3 rounded-lg {{ $index % 2 == 0 ? 'bg-blue-50' : 'bg-indigo-50' }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br {{ $index == 0 ? 'from-yellow-400 to-yellow-600' : ($index == 1 ? 'from-gray-300 to-gray-500' : 'from-amber-600 to-amber-800') }} flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <span class="ml-3 font-medium text-gray-800">{{ $company->company_name }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="font-bold text-blue-600">{{ $company->vehicle_count }}</span>
                                <span class="ml-1 text-sm text-gray-500">véhicules</span>
                            </div>
                        </li>
                    @empty
                        <li class="text-center p-4 text-gray-500 italic">Aucune donnée disponible</li>
                    @endforelse
                </ul>
            </div>
        </div>
        
        <!-- Top Companies By Reservations -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 flex items-center">
                    <i class="fas fa-crown text-yellow-500 mr-2"></i>
                    Top Entreprises par Réservations
                </h3>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    @forelse($topCompaniesByReservations as $index => $company)
                        <li class="flex items-center justify-between p-3 rounded-lg {{ $index % 2 == 0 ? 'bg-purple-50' : 'bg-pink-50' }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br {{ $index == 0 ? 'from-yellow-400 to-yellow-600' : ($index == 1 ? 'from-gray-300 to-gray-500' : 'from-amber-600 to-amber-800') }} flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <span class="ml-3 font-medium text-gray-800">{{ $company->company_name }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="font-bold text-purple-600">{{ $company->reservation_count }}</span>
                                <span class="ml-1 text-sm text-gray-500">réservations</span>
                            </div>
                        </li>
                    @empty
                        <li class="text-center p-4 text-gray-500 italic">Aucune donnée disponible</li>
                    @endforelse
                </ul>
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