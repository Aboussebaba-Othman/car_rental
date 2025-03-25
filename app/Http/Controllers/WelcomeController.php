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
    
    public function index()
    {
        // Get featured vehicles - active and available vehicles, limited to 6
        $featuredVehicles = $this->vehicleRepository->getFeaturedVehicles();
            
        // Get active promotions, limited to 3
        $activePromotions = $this->promotionRepository->getActivePromotions(3);
            
        return view('welcome', compact('featuredVehicles', 'activePromotions'));
    }
}
