<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Interfaces\PromotionRepositoryInterface;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    private $vehicleRepository;
    private $promotionRepository;
    
    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        PromotionRepositoryInterface $promotionRepository
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->promotionRepository = $promotionRepository;
    }
    
    /**
     * Display a listing of the vehicles with advanced filtering options
     */
    public function index(Request $request)
    {
        // Process search filters
        $filters = [
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'fuel_type' => $request->input('fuel_type'),
            'transmission' => $request->input('transmission'),
            'seats' => $request->input('seats'),
            'price_min' => $request->input('price_min'),
            'price_max' => $request->input('price_max'),
        ];
        
        // Get paginated vehicles with more items per page for the dedicated page
        $vehicles = $this->vehicleRepository->getPaginatedVehicles(
            $filters,
            $request->input('sort', 'newest'),
            12 // More items per page for the vehicles page
        );
        
        // Get active promotions for sidebar
        $activePromotions = $this->promotionRepository->getActivePromotions(null, 3);
        
        // Get filter options for dropdowns
        $brands = $this->vehicleRepository->getAllBrands();
        
        return view('vehicles.index', compact(
            'vehicles',
            'activePromotions',
            'brands',
            'filters'
        ));
    }
    
    /**
     * Display the specified vehicle with available promotions
     */
    public function show($id)
    {
        // Get vehicle with all its relations
        $vehicle = $this->vehicleRepository->findWithRelations($id);
        
        if (!$vehicle || !$vehicle->is_active) {
            abort(404);
        }
        
        // Get applicable promotions for this vehicle
        $applicablePromotions = $this->promotionRepository->getApplicableToVehicle($vehicle->id);
        
        // Get similar vehicles (same brand or type)
        $similarVehicles = $this->vehicleRepository->getSimilarVehicles($vehicle, 3);
        
        return view('vehicles.show', compact(
            'vehicle',
            'applicablePromotions',
            'similarVehicles'
        ));
    }
}