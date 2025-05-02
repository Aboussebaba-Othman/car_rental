<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Reservation;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::user()->admin;
        
        // Get current month and previous month dates
        $now = Carbon::now();
        $currentMonth = $now->format('Y-m');
        $previousMonth = $now->copy()->subMonth()->format('Y-m');
        
        // Count statistics for current and previous months
        $usersCurrentMonth = User::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();
            
        $usersPreviousMonth = User::whereYear('created_at', $now->copy()->subMonth()->year)
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->count();
            
        $companiesCurrentMonth = Company::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();
            
        $companiesPreviousMonth = Company::whereYear('created_at', $now->copy()->subMonth()->year)
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->count();
            
        $vehiclesCurrentMonth = Vehicle::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();
            
        $vehiclesPreviousMonth = Vehicle::whereYear('created_at', $now->copy()->subMonth()->year)
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->count();
            
        $reservationsCurrentMonth = Reservation::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();
            
        $reservationsPreviousMonth = Reservation::whereYear('created_at', $now->copy()->subMonth()->year)
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->count();
        
        // Calculate percentage changes
        $userChange = $usersPreviousMonth > 0 
            ? round(($usersCurrentMonth - $usersPreviousMonth) / $usersPreviousMonth * 100, 1)
            : ($usersCurrentMonth > 0 ? 100 : 0);
            
        $companyChange = $companiesPreviousMonth > 0
            ? round(($companiesCurrentMonth - $companiesPreviousMonth) / $companiesPreviousMonth * 100, 1)
            : ($companiesCurrentMonth > 0 ? 100 : 0);
            
        $vehicleChange = $vehiclesPreviousMonth > 0
            ? round(($vehiclesCurrentMonth - $vehiclesPreviousMonth) / $vehiclesPreviousMonth * 100, 1)
            : ($vehiclesCurrentMonth > 0 ? 100 : 0);
            
        $reservationChange = $reservationsPreviousMonth > 0
            ? round(($reservationsCurrentMonth - $reservationsPreviousMonth) / $reservationsPreviousMonth * 100, 1)
            : ($reservationsCurrentMonth > 0 ? 100 : 0);
        
        // Prepare statistics array for view
        $stats = [
            'users' => User::count(),
            'companies' => Company::count(),
            'vehicles' => Vehicle::count(),
            'reservations' => Reservation::count(),
            'user_change' => $userChange,
            'company_change' => $companyChange,
            'vehicle_change' => $vehicleChange,
            'reservation_change' => $reservationChange,
            'usersCurrentMonth' => $usersCurrentMonth,
            'companiesCurrentMonth' => $companiesCurrentMonth,
            'vehiclesCurrentMonth' => $vehiclesCurrentMonth,
            'reservationsCurrentMonth' => $reservationsCurrentMonth,
            'currentMonthName' => $now->translatedFormat('F Y'),
        ];
        
        // Get data for charts
        $lastSixMonths = collect([]);
        for ($i = 5; $i >= 0; $i--) {
            $lastSixMonths->push($now->copy()->subMonths($i)->format('M Y'));
        }
        
        $reservationData = [];
        foreach (range(5, 0) as $i) {
            $month = $now->copy()->subMonths($i);
            $reservationData[] = Reservation::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }
        
        // Get vehicle categories data - fixing the unknown column issue
        // Let's check if we can find an appropriate category column
        $vehicleColumns = Schema::getColumnListing('vehicles');
        
        $categoryColumn = 'type'; // Default to a likely column name for vehicle type
        
        // Check for common category column names
        $possibleColumns = ['type', 'vehicle_type', 'class', 'model', 'brand', 'category_id'];
        foreach ($possibleColumns as $column) {
            if (in_array($column, $vehicleColumns)) {
                $categoryColumn = $column;
                break;
            }
        }
        
        // Get vehicle categories data using the found column
        try {
            $categories = Vehicle::select($categoryColumn, DB::raw('count(*) as total'))
                ->whereNotNull($categoryColumn)
                ->groupBy($categoryColumn)
                ->pluck('total', $categoryColumn)
                ->toArray();
                
            $categoryLabels = array_keys($categories);
            $categoryData = array_values($categories);
        } catch (\Exception $e) {
            // Fallback if query fails
            $categories = [];
            $categoryLabels = [];
            $categoryData = [];
        }
        
        // Prepare charts array
        $charts = [
            'months' => $lastSixMonths->toArray(),
            'reservationData' => $reservationData,
            'categories' => $categoryLabels,
            'categoryData' => $categoryData
        ];
        
        // Get recent activity with error handling for missing table
        try {
            // Check if the table exists before querying
            if (Schema::hasTable('activity_log')) {
                $recentActivity = DB::table('activity_log')
                    ->latest()
                    ->take(10)
                    ->get();
            } else {
                // Use recent reservations as activity if activity_log doesn't exist
                $recentActivity = Reservation::with('user')
                    ->latest()
                    ->take(10)
                    ->get()
                    ->map(function($reservation) {
                        $reservation->description = "Réservation #" . $reservation->id;
                        $reservation->status = $reservation->status ?? 'completed';
                        return $reservation;
                    });
            }
        } catch (QueryException $e) {
            // Fallback to an empty collection if query fails
            $recentActivity = new Collection();
        }
        
        // Check for the actual company name column
        $companyColumns = Schema::getColumnListing('companies');
        $companyNameColumn = 'name'; // Default assumption
        
        // Check for common name column alternatives
        $possibleNameColumns = ['name', 'company_name', 'title', 'nom', 'label', 'raison_sociale'];
        foreach ($possibleNameColumns as $column) {
            if (in_array($column, $companyColumns)) {
                $companyNameColumn = $column;
                break;
            }
        }
        
        // Get top 5 companies by vehicle count - Fixed column name issue
        try {
            $topCompaniesByVehicles = DB::table('companies')
                ->select('companies.id', "companies.{$companyNameColumn} as company_name", DB::raw('COUNT(vehicles.id) as vehicle_count'))
                ->leftJoin('vehicles', 'companies.id', '=', 'vehicles.company_id')
                ->groupBy('companies.id', "companies.{$companyNameColumn}")
                ->orderByDesc('vehicle_count')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Fallback if query fails
            $topCompaniesByVehicles = new Collection();
        }
            
        // Get top 5 companies by reservation count - Fixed column name issue
        try {
            $topCompaniesByReservations = DB::table('companies')
                ->select('companies.id', "companies.{$companyNameColumn} as company_name", DB::raw('COUNT(reservations.id) as reservation_count'))
                ->leftJoin('vehicles', 'companies.id', '=', 'vehicles.company_id')
                ->leftJoin('reservations', 'vehicles.id', '=', 'reservations.vehicle_id')
                ->groupBy('companies.id', "companies.{$companyNameColumn}")
                ->orderByDesc('reservation_count')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Fallback if query fails
            $topCompaniesByReservations = new Collection();
        }
        
        // Get monthly reservation stats for the current year
        $monthlyStats = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create(Carbon::now()->year, $i, 1);
            $monthlyStats[] = [
                'month' => $month->translatedFormat('F'),
                'count' => Reservation::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count()
            ];
        }
        
        // Get weekly reservation stats for the last 10 weeks
        $weeklyStats = [];
        for ($i = 9; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $weekNumber = $startOfWeek->weekOfYear;
            $weekLabel = 'S' . $weekNumber . ' (' . $startOfWeek->format('d/m') . ' - ' . $endOfWeek->format('d/m') . ')';
            
            $weeklyStats[] = [
                'week' => $weekLabel,
                'count' => Reservation::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count()
            ];
        }
        
        // Prepare extended charts data
        $advancedCharts = [
            'months' => array_column($monthlyStats, 'month'),
            'monthlyData' => array_column($monthlyStats, 'count'),
            'weeks' => array_column($weeklyStats, 'week'),
            'weeklyData' => array_column($weeklyStats, 'count'),
            'topVehicleCompanies' => [
                'labels' => $topCompaniesByVehicles->pluck('company_name')->toArray(),
                'data' => $topCompaniesByVehicles->pluck('vehicle_count')->toArray(),
            ],
            'topReservationCompanies' => [
                'labels' => $topCompaniesByReservations->pluck('company_name')->toArray(),
                'data' => $topCompaniesByReservations->pluck('reservation_count')->toArray(),
            ]
        ];
        
        return view('admin.dashboard', compact(
            'admin', 
            'stats', 
            'charts',
            'advancedCharts',
            'topCompaniesByVehicles',
            'topCompaniesByReservations',
            'monthlyStats',
            'weeklyStats'
        ));
    }
}