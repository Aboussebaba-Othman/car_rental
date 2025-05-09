<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Company;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with(['photos', 'company'])
            ->where('is_active', true)
            ->where('is_available', true);

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

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

        $pageTitle = 'Véhicules disponibles';
        if ($request->has('company_id')) {
            $company = Company::find($request->company_id);
            if ($company) {
                $pageTitle = 'Véhicules de ' . $company->name;
            }
        }

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

        if (!$vehicle->is_active || !$vehicle->is_available) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Ce véhicule n\'est pas disponible à la location.');
        }

        $promotion = null;
        $activePromotions = Promotion::active()->get();
        
        foreach ($activePromotions as $activePromotion) {
            if ($activePromotion->applicable_vehicles === null || 
                (is_array($activePromotion->applicable_vehicles) && in_array($vehicle->id, $activePromotion->applicable_vehicles))) {
                $promotion = $activePromotion;
                $promotion->is_active = true;
                break;
            }
        }

        return view('vehicles.show', compact('vehicle', 'promotion'));
    }

    
    public function getAvailability(Vehicle $vehicle, Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer|min:0|max:11',
        ]);
        
        $year = $request->input('year');
        $month = $request->input('month');
        
        $startDate = Carbon::create($year, $month + 1, 1)->startOfDay();
        $endDate = Carbon::create($year, $month + 1, 1)->endOfMonth()->startOfDay();
        
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
        
        $daysInMonth = $endDate->day;
        $unavailableDates = [];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $checkDate = Carbon::create($year, $month + 1, $day)->startOfDay();
            
            if ($checkDate->isPast()) {
                continue;
            }
            
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