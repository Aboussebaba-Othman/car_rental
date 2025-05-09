<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Company;
  

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with(['company', 'photos' => function($query) {
            $query->where('is_primary', true)->orWhere('display_order', 1);
        }]);
        
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }
        
        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('is_available', true)->where('is_active', true);
            } elseif ($request->availability === 'unavailable') {
                $query->where('is_available', false);
            } elseif ($request->availability === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($query) use ($search) {
                $query->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('license_plate', 'like', "%{$search}%")
                      ->orWhere('year', 'like', "%{$search}%");
            });
        }
        
        $vehicles = $query->paginate(9);
        $companies = Company::select('id', 'company_name')->get();
        
        return view('admin.vehicles.index', compact('vehicles', 'companies'));
    }

   
    public function show($id)
    {
        $vehicle = Vehicle::with(['company', 'photos', 'reservations.user', 'reviews'])->findOrFail($id);
        return view('admin.vehicles.show', compact('vehicle'));
    }
}
