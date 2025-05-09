<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Interfaces\PromotionRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    private $vehicleRepository;
    private $promotionRepository;
    private $companyRepository;
    
    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        PromotionRepositoryInterface $promotionRepository,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->promotionRepository = $promotionRepository;
        $this->companyRepository = $companyRepository;
    }
    
    public function index(Request $request)
    {
        $activePromotions = $this->promotionRepository->getActivePromotions(null, 3);
        
        $filters = [
            'location' => $request->input('location'),
            'brand' => $request->input('brand'),
            'fuel_type' => $request->input('fuel_type'),
            'seats' => $request->input('seats'),
            'price_min' => $request->input('price_min'),
            'price_max' => $request->input('price_max'),
        ];
        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $vehicles = $this->vehicleRepository->getAvailableVehicles(
            $filters,
            $startDate,
            $endDate,
            $request->input('sort', 'newest'),
            6 
        );
        
        $promotionId = $request->input('promo');
        $selectedPromotion = null;
        
        if ($promotionId) {
            try {
                $selectedPromotion = $this->promotionRepository->find($promotionId);
                if (!$selectedPromotion->isValid()) {
                    $selectedPromotion = null;
                }
            } catch (\Exception $e) {
                // Promotion not found or not valid
            }
        }
        
        $brands = $this->vehicleRepository->getAllBrands();
        
        $cities = $this->companyRepository->getAllCities();
        
        return view('welcome', compact(
            'vehicles',
            'activePromotions',
            'selectedPromotion',
            'brands',
            'filters',
            'startDate',
            'endDate',
            'cities'
        ));
    }
}