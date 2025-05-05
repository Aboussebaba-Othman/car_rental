<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with(['photos', 'company'])
            ->where('is_active', true)
            ->where('is_available', true);

        // Filter by company if company_id is provided
        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Apply filters if provided
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->filled('price_min')) {
            $query->where('price_per_day', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_day', '<=', $request->price_max);
        }

        // Apply sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price_per_day', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_per_day', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $vehicles = $query->paginate(12);

        // Add company name to the page title if filtering by company
        $pageTitle = 'Véhicules disponibles';
        if ($request->has('company_id')) {
            $company = \App\Models\Company::find($request->company_id);
            if ($company) {
                $pageTitle = 'Véhicules de ' . $company->name;
            }
        }

        // Get unique brands for filtering
        $brands = Vehicle::where('is_active', true)
            ->where('is_available', true)
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        return view('vehicles.index', [
            'vehicles' => $vehicles,
            'brands' => $brands,
            'pageTitle' => $pageTitle
        ]);
    }

    public function show($id)
    {
        $vehicle = Vehicle::with(['photos', 'company'])->findOrFail($id);

        // Check if vehicle is active and available
        if (!$vehicle->is_active || !$vehicle->is_available) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Ce véhicule n\'est pas disponible à la location.');
        }

        // Get active promotion if any
        $promotion = null;
        $activePromotions = Promotion::active()->get();
        
        foreach ($activePromotions as $activePromotion) {
            // Check if this promotion applies to all vehicles or specifically to this one
            if ($activePromotion->applicable_vehicles === null || 
                (is_array($activePromotion->applicable_vehicles) && in_array($vehicle->id, $activePromotion->applicable_vehicles))) {
                $promotion = $activePromotion;
                $promotion->is_active = true;
                break;
            }
        }

        return view('vehicles.show', compact('vehicle', 'promotion'));
    }

    /**
     * Get vehicle availability for a specific month
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAvailability(Vehicle $vehicle, Request $request)
    {
        // Validate request
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer|min:0|max:11',
        ]);
        
        $year = $request->input('year');
        $month = $request->input('month');
        
        // Get the first and last day of the requested month
        $startDate = Carbon::create($year, $month + 1, 1)->startOfDay();
        $endDate = Carbon::create($year, $month + 1, 1)->endOfMonth()->startOfDay();
        
        // Get all confirmed reservations for this vehicle in the specified month
        $reservations = $vehicle->reservations()
            ->where('status', 'confirmed')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->get();
        
        // Generate array of all days in the month
        $daysInMonth = $endDate->day;
        $unavailableDates = [];
        
        // For each day, check if the vehicle is available
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $checkDate = Carbon::create($year, $month + 1, $day)->startOfDay();
            
            // Skip dates in the past
            if ($checkDate->isPast()) {
                continue;
            }
            
            // Check if this date is within any reservation
            foreach ($reservations as $reservation) {
                $resStart = Carbon::parse($reservation->start_date)->startOfDay();
                $resEnd = Carbon::parse($reservation->end_date)->startOfDay();
                
                if ($checkDate->between($resStart, $resEnd)) {
                    $unavailableDates[] = $checkDate->format('Y-m-d');
                    break;
                }
            }
        }
        
        return response()->json([
            'unavailableDates' => $unavailableDates,
        ]);
    }
}
