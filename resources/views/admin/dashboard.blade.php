@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tableau de Bord</h1>
            <p class="text-gray-600 mt-1">Vue d'ensemble et statistiques du système</p>
        </div>
        <div>
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200 ease-in-out">
                <i class="fas fa-download mr-2"></i> Exporter les statistiques
            </button>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Utilisateurs -->
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-blue-500 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Utilisateurs</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="text-green-500 mr-2 flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            {{ $userIncrease }}%
                        </span>
                        <span class="text-xs text-gray-500">Depuis le mois dernier</span>
                    </div>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </div>
            </div>
            <div class="mt-6 flex justify-between text-sm">
                <div>
                    <p class="text-gray-500">Actifs</p>
                    <p class="font-semibold">{{ $activeUsers }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Inscrits ce mois</p>
                    <p class="font-semibold">{{ $newUsers }}</p>
                </div>
            </div>
        </div>

        <!-- Entreprises -->
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-purple-500 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Entreprises</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCompanies }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="text-green-500 mr-2 flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            {{ $companyIncrease }}%
                        </span>
                        <span class="text-xs text-gray-500">Depuis le mois dernier</span>
                    </div>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="mt-6 flex justify-between text-sm">
                <div>
                    <p class="text-gray-500">Validées</p>
                    <p class="font-semibold">{{ $validatedCompanies }}</p>
                </div>
                <div>
                    <p class="text-gray-500">En attente</p>
                    <p class="font-semibold text-yellow-600">{{ $pendingCompanies }}</p>
                </div>
            </div>
        </div>

        <!-- Véhicules -->
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-green-500 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Véhicules</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalVehicles }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="text-green-500 mr-2 flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            {{ $vehicleIncrease }}%
                        </span>
                        <span class="text-xs text-gray-500">Depuis le mois dernier</span>
                    </div>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3zm0 2h12v.586l3 3V15h-1.05a2.5 2.5 0 00-4.9 0H9a1 1 0 01-1 1v1H4a1 1 0 01-1-1V6z" />
                    </svg>
                </div>
            </div>
            <div class="mt-6 flex justify-between text-sm">
                <div>
                    <p class="text-gray-500">Actifs</p>
                    <p class="font-semibold">{{ $activeVehicles }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Inactifs</p>
                    <p class="font-semibold">{{ $inactiveVehicles }}</p>
                </div>
            </div>
        </div>

        <!-- Réservations -->
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-yellow-500 transform transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Réservations</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalReservations }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="text-green-500 mr-2 flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            {{ $reservationIncrease }}%
                        </span>
                        <span class="text-xs text-gray-500">Depuis le mois dernier</span>
                    </div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="mt-6 flex justify-between text-sm">
                <div>
                    <p class="text-gray-500">Confirmées</p>
                    <p class="font-semibold text-green-600">{{ $confirmedReservations }}</p>
                </div>
                <div>
                    <p class="text-gray-500">En attente</p>
                    <p class="font-semibold text-yellow-600">{{ $pendingReservations }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Annulées</p>
                    <p class="font-semibold text-red-600">{{ $canceledReservations }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques détaillées -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenus -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-5 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Revenus générés</h2>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-sm text-gray-500">Revenus totaux</span>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalRevenue, 2, ',', ' ') }} €</h3>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Ce mois</span>
                        <h3 class="text-xl font-bold text-gray-800">{{ number_format($monthlyRevenue, 2, ',', ' ') }} €</h3>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Objectif mensuel</span>
                        <span class="font-medium">{{ $revenuePercentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $revenuePercentage }}%"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-600">Paiements confirmés</span>
                            <span class="text-green-600 text-xs font-medium">{{ $confirmedPaymentPercentage }}%</span>
                        </div>
                        <h4 class="text-lg font-semibold">{{ number_format($confirmedPayments, 2, ',', ' ') }} €</h4>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-600">Paiements en attente</span>
                            <span class="text-yellow-600 text-xs font-medium">{{ $pendingPaymentPercentage }}%</span>
                        </div>
                        <h4 class="text-lg font-semibold">{{ number_format($pendingPayments, 2, ',', ' ') }} €</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signalements et litiges -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-5 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Signalements et litiges</h2>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-sm text-gray-500">Total des signalements</span>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalReports }}</h3>
                    </div>
                    <div>
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $pendingReports }} en attente</span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Litiges clients</span>
                            <span class="text-sm text-gray-600">{{ $customerDisputes }} signalements</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ ($customerDisputes / $totalReports) * 100 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Problèmes véhicules</span>
                            <span class="text-sm text-gray-600">{{ $vehicleIssues }} signalements</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-orange-500 h-2.5 rounded-full" style="width: {{ ($vehicleIssues / $totalReports) * 100 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Fraudes</span>
                            <span class="text-sm text-gray-600">{{ $fraudReports }} signalements</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ ($fraudReports / $totalReports) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        Voir tous les signalements
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statut des véhicules -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="p-5 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Statut des véhicules</h2>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <span class="text-sm text-gray-600">Disponibles</span>
                    <h3 class="text-xl font-bold text-green-600 mt-1">{{ $availableVehicles }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $availableVehiclePercentage }}% du total</p>
                </div>
                
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <span class="text-sm text-gray-600">En location</span>
                    <h3 class="text-xl font-bold text-blue-600 mt-1">{{ $rentedVehicles }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $rentedVehiclePercentage }}% du total</p>
                </div>
                
                <div class="bg-orange-50 rounded-lg p-4 text-center">
                    <span class="text-sm text-gray-600">En maintenance</span>
                    <h3 class="text-xl font-bold text-orange-600 mt-1">{{ $maintenanceVehicles }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $maintenanceVehiclePercentage }}% du total</p>
                </div>
                
                <div class="bg-red-50 rounded-lg p-4 text-center">
                    <span class="text-sm text-gray-600">Inactifs</span>
                    <h3 class="text-xl font-bold text-red-600 mt-1">{{ $inactiveVehicles }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $inactiveVehiclePercentage }}% du total</p>
                </div>
            </div>
            
            <div class="mt-6">
                <h4 class="font-medium text-gray-700 mb-2">Distribution par catégorie</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex flex-wrap gap-2">
                        @foreach($vehicleCategories as $category)
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-1" style="background-color: {{ $category['color'] }}"></div>
                            <span class="text-sm text-gray-700">{{ $category['name'] }}: {{ $category['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="w-full h-4 rounded-full bg-gray-200 mt-2 overflow-hidden">
                        @foreach($vehicleCategories as $category)
                        <div class="h-full float-left" style="width: {{ $category['percentage'] }}%; background-color: {{ $category['color'] }}"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Réservations par statut -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-5 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Statut des réservations</h2>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-2">
                    <canvas id="reservationsChart" class="w-full h-64"></canvas>
                </div>
                
                <div>
                    <div class="space-y-4">
                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Confirmées</span>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $confirmedReservationPercentage }}%</span>
                            </div>
                            <h4 class="text-lg font-semibold text-green-600">{{ $confirmedReservations }}</h4>
                        </div>
                        
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">En attente</span>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $pendingReservationPercentage }}%</span>
                            </div>
                            <h4 class="text-lg font-semibold text-yellow-600">{{ $pendingReservations }}</h4>
                        </div>
                        
                        <div class="bg-red-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Annulées</span>
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $canceledReservationPercentage }}%</span>
                            </div>
                            <h4 class="text-lg font-semibold text-red-600">{{ $canceledReservations }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des réservations
    const ctx = document.getElementById('reservationsChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($reservationChartLabels),
            datasets: [
                {
                    label: 'Confirmées',
                    data: @json($confirmedReservationData),
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'En attente',
                    data: @json($pendingReservationData),
                    backgroundColor: 'rgba(245, 158, 11, 0.2)',
                    borderColor: 'rgba(245, 158, 11, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Annulées',
                    data: @json($canceledReservationData),
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
    
    // Animation des compteurs
    const counters = document.querySelectorAll('.text-2xl.font-bold.text-gray-800');
    
    counters.forEach(counter => {
        const target = parseFloat(counter.innerText.replace(/,/g, '').replace(' €', ''));
        const duration = 1500;
        const increment = target / duration * 10;
        let current = 0;
        
        const updateCount = () => {
            current += increment;
            if (current < target) {
                counter.innerText = counter.innerText.includes('€') ? 
                    Math.ceil(current).toLocaleString('fr-FR') + ' €' : 
                    Math.ceil(current).toLocaleString('fr-FR');
                setTimeout(updateCount, 10);
            } else {
                counter.innerText = counter.innerText.includes('€') ? 
                    Math.ceil(target).toLocaleString('fr-FR') + ' €' : 
                    Math.ceil(target).toLocaleString('fr-FR');
            }
        };
        
        updateCount();
    });
});
</script>
@endsection