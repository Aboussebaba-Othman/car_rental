<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Report;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques utilisateurs
        $totalUsers = User::where('role_id', 1)->count();
        $activeUsers = User::where('role_id', 1)->where('is_active', true)->count();
        $lastMonthUsers = User::where('role_id', 1)
            ->where('created_at', '<=', Carbon::now()->subMonth())
            ->count();
        $currentUsers = User::where('role_id', 1)->count();
        $userIncrease = $lastMonthUsers > 0 
            ? round((($currentUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) 
            : 100;
        $newUsers = User::where('role_id', 1)
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        // Statistiques entreprises
        $totalCompanies = Company::count();
        $validatedCompanies = Company::where('is_validated', true)->count();
        $pendingCompanies = Company::where('is_validated', false)->count();
        $lastMonthCompanies = Company::where('created_at', '<=', Carbon::now()->subMonth())->count();
        $currentCompanies = Company::count();
        $companyIncrease = $lastMonthCompanies > 0 
            ? round((($currentCompanies - $lastMonthCompanies) / $lastMonthCompanies) * 100, 1) 
            : 100;
        
        // Statistiques véhicules
        $totalVehicles = Vehicle::count();
        $activeVehicles = Vehicle::where('availability', true)->count();
        $inactiveVehicles = Vehicle::where('availability', false)->count();
        $availableVehicles = Vehicle::where('availability', true)
            ->whereDoesntHave('reservations', function($query) {
                $query->where('status', 'confirmed')
                    ->where('start_date', '<=', Carbon::now())
                    ->where('end_date', '>=', Carbon::now());
            })->count();
        $rentedVehicles = $activeVehicles - $availableVehicles;
        $maintenanceVehicles = Vehicle::where('status', 'maintenance')->count();
        $lastMonthVehicles = Vehicle::where('created_at', '<=', Carbon::now()->subMonth())->count();
        $currentVehicles = Vehicle::count();
        $vehicleIncrease = $lastMonthVehicles > 0 
            ? round((($currentVehicles - $lastMonthVehicles) / $lastMonthVehicles) * 100, 1) 
            : 100;
            
        // Calcul des pourcentages de véhicules
        $availableVehiclePercentage = $totalVehicles > 0 ? round(($availableVehicles / $totalVehicles) * 100, 1) : 0;
        $rentedVehiclePercentage = $totalVehicles > 0 ? round(($rentedVehicles / $totalVehicles) * 100, 1) : 0;
        $maintenanceVehiclePercentage = $totalVehicles > 0 ? round(($maintenanceVehicles / $totalVehicles) * 100, 1) : 0;
        $inactiveVehiclePercentage = $totalVehicles > 0 ? round(($inactiveVehicles / $totalVehicles) * 100, 1) : 0;
        
        // Catégories de véhicules
        $vehicleCategories = [
            [
                'name' => 'Économique',
                'count' => Vehicle::where('category', 'economy')->count(),
                'percentage' => $totalVehicles > 0 ? (Vehicle::where('category', 'economy')->count() / $totalVehicles) * 100 : 0,
                'color' => '#3B82F6' // blue
            ],
            [
                'name' => 'Confort',
                'count' => Vehicle::where('category', 'comfort')->count(),
                'percentage' => $totalVehicles > 0 ? (Vehicle::where('category', 'comfort')->count() / $totalVehicles) * 100 : 0,
                'color' => '#10B981' // green
            ],
            [
                'name' => 'SUV',
                'count' => Vehicle::where('category', 'suv')->count(),
                'percentage' => $totalVehicles > 0 ? (Vehicle::where('category', 'suv')->count() / $totalVehicles) * 100 : 0,
                'color' => '#F59E0B' // amber
            ],
            [
                'name' => 'Luxe',
                'count' => Vehicle::where('category', 'luxury')->count(),
                'percentage' => $totalVehicles > 0 ? (Vehicle::where('category', 'luxury')->count() / $totalVehicles) * 100 : 0,
                'color' => '#8B5CF6' // purple
            ],
            [
                'name' => 'Utilitaires',
                'count' => Vehicle::where('category', 'utility')->count(),
                'percentage' => $totalVehicles > 0 ? (Vehicle::where('category', 'utility')->count() / $totalVehicles) * 100 : 0,
                'color' => '#EC4899' // pink
            ]
        ];

        // Statistiques réservations
        $totalReservations = Reservation::count();
        $confirmedReservations = Reservation::where('status', 'confirmed')->count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $canceledReservations = Reservation::where('status', 'canceled')->count();
        $lastMonthReservations = Reservation::where('created_at', '<=', Carbon::now()->subMonth())->count();
        $currentReservations = Reservation::count();
        $reservationIncrease = $lastMonthReservations > 0 
            ? round((($currentReservations - $lastMonthReservations) / $lastMonthReservations) * 100, 1) 
            : 100;
            
        // Calcul des pourcentages de réservations
        $confirmedReservationPercentage = $totalReservations > 0 ? round(($confirmedReservations / $totalReservations) * 100, 1) : 0;
        $pendingReservationPercentage = $totalReservations > 0 ? round(($pendingReservations / $totalReservations) * 100, 1) : 0;
        $canceledReservationPercentage = $totalReservations > 0 ? round(($canceledReservations / $totalReservations) * 100, 1) : 0;
        
        // Données pour le graphique des réservations (6 derniers mois)
        $reservationChartLabels = [];
        $confirmedReservationData = [];
        $pendingReservationData = [];
        $canceledReservationData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $reservationChartLabels[] = $month->format('M Y');
            
            $confirmedReservationData[] = Reservation::where('status', 'confirmed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $pendingReservationData[] = Reservation::where('status', 'pending')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $canceledReservationData[] = Reservation::where('status', 'canceled')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }
        
        // Statistiques revenus
        $totalRevenue = Payment::where('status', 'confirmed')->sum('amount');
        $monthlyRevenue = Payment::where('status', 'confirmed')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        $monthlyTarget = 20000; // Objectif mensuel fictif
        $revenuePercentage = $monthlyTarget > 0 ? round(($monthlyRevenue / $monthlyTarget) * 100, 1) : 0;
        $confirmedPayments = Payment::where('status', 'confirmed')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->sum('amount');
        $confirmedPaymentPercentage = ($confirmedPayments + $pendingPayments) > 0 
            ? round(($confirmedPayments / ($confirmedPayments + $pendingPayments)) * 100, 1) 
            : 0;
        $pendingPaymentPercentage = ($confirmedPayments + $pendingPayments) > 0 
            ? round(($pendingPayments / ($confirmedPayments + $pendingPayments)) * 100, 1) 
            : 0;
            
        // Statistiques signalements
        $totalReports = Report::count();
        $pendingReports = Report::where('status', 'pending')->count();
        $customerDisputes = Report::where('type', 'customer_dispute')->count();
        $vehicleIssues = Report::where('type', 'vehicle_issue')->count();
        $fraudReports = Report::where('type', 'fraud')->count();
        
        // Entreprises en attente de validation
        $pendingCompaniesData = Company::with('user')
            ->where('is_validated', false)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'activeUsers', 'userIncrease', 'newUsers',
            'totalCompanies', 'validatedCompanies', 'pendingCompanies', 'companyIncrease',
            'totalVehicles', 'activeVehicles', 'inactiveVehicles', 'availableVehicles', 
            'rentedVehicles', 'maintenanceVehicles', 'vehicleIncrease',
            'availableVehiclePercentage', 'rentedVehiclePercentage', 
            'maintenanceVehiclePercentage', 'inactiveVehiclePercentage', 'vehicleCategories',
            'totalReservations', 'confirmedReservations', 'pendingReservations', 
            'canceledReservations', 'reservationIncrease',
            'confirmedReservationPercentage', 'pendingReservationPercentage', 'canceledReservationPercentage',
            'reservationChartLabels', 'confirmedReservationData', 'pendingReservationData', 'canceledReservationData',
            'totalRevenue', 'monthlyRevenue', 'revenuePercentage',
            'confirmedPayments', 'pendingPayments', 'confirmedPaymentPercentage', 'pendingPaymentPercentage',
            'totalReports', 'pendingReports', 'customerDisputes', 'vehicleIssues', 'fraudReports',
            'pendingCompaniesData'
        ));
    }
}