<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Interfaces\PromotionRepositoryInterface;
use Illuminate\Http\Request;

class WelcomeController extends Controller
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
    
    public function index(Request $request)
    {
        // Get active promotions, limited to 3
        $activePromotions = $this->promotionRepository->getActivePromotions(null, 3);
        
        // Process search filters
        $filters = [
            'brand' => $request->input('brand'),
            'fuel_type' => $request->input('fuel_type'),
            'seats' => $request->input('seats'),
            'price_min' => $request->input('price_min'),
            'price_max' => $request->input('price_max'),
        ];
        
        // Get paginated vehicles
        $vehicles = $this->vehicleRepository->getPaginatedVehicles(
            $filters,
            $request->input('sort', 'newest'),
            6 // Items per page
        );
        
        // If there's a promotion ID in the query, get the promotion details
        $promotionId = $request->input('promo');
        $selectedPromotion = null;
        
        if ($promotionId) {
            try {
                $selectedPromotion = $this->promotionRepository->find($promotionId);
                // Check if promotion is valid
                if (!$selectedPromotion->isValid()) {
                    $selectedPromotion = null;
                }
            } catch (\Exception $e) {
                // Promotion not found or not valid
            }
        }
        
        // Get brands for filter dropdown
        $brands = $this->vehicleRepository->getAllBrands();
        
        return view('welcome', compact(
            'vehicles',
            'activePromotions',
            'selectedPromotion',
            'brands',
            'filters'
        ));
    }
}