<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Repositories\Interfaces\PromotionRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Vehicle;

class PromotionController extends Controller
{
    private $promotionRepository;
    private $vehicleRepository;
    
    public function __construct(
        PromotionRepositoryInterface $promotionRepository,
        VehicleRepositoryInterface $vehicleRepository
    ) {
        $this->promotionRepository = $promotionRepository;
        $this->vehicleRepository = $vehicleRepository;
    }
    
    public function index()
    {
        $company = Auth::user()->company;
        $promotions = $this->promotionRepository->getAllForCompany($company->id);
        $stats = $this->promotionRepository->getPromotionStats($company->id);
        
        $activePromotions = $this->promotionRepository->getActivePromotions($company->id);
        $upcomingPromotions = $this->promotionRepository->getUpcomingPromotions($company->id);
        
        return view('company.promotions.index', compact(
            'promotions', 
            'stats', 
            'activePromotions', 
            'upcomingPromotions'
        ));
    }
    
    public function create()
    {
        $company = Auth::user()->company;
        $vehicles = $this->vehicleRepository->getAllForCompany($company->id);
        
        return view('company.promotions.create', compact('vehicles'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'applicable_vehicles' => 'nullable|array',
            'applicable_vehicles.*' => 'exists:vehicles,id',
        ]);
        
        $companyId = Auth::user()->company->id;
        
        $isGlobalPromotion = !$request->has('applicable_vehicles');
        
        if ($isGlobalPromotion) {
            $activePromotionsCount = Promotion::where('company_id', $companyId)
                ->where('is_active', true)
                ->where('start_date', '<=', now()->startOfDay())
                ->where('end_date', '>=', now()->startOfDay())
                ->count();
            
            if ($activePromotionsCount > 0) {
                return back()->withErrors([
                    'applicable_vehicles' => 'Une promotion globale ne peut pas être créée car des promotions actives existent déjà. Désactivez les promotions existantes d\'abord.'
                ])->withInput();
            }
        } else {
            $vehicleIds = $request->applicable_vehicles;
            
            $validVehicleCount = $this->vehicleRepository->countVehiclesByCompanyAndIds($companyId, $vehicleIds);
            
            if ($validVehicleCount != count($vehicleIds)) {
                return back()->withErrors([
                    'applicable_vehicles' => 'Vous ne pouvez sélectionner que des véhicules appartenant à votre entreprise.'
                ])->withInput();
            }
            
            list($hasConflict, $conflictingVehicles, $conflictingPromotions) = 
                $this->checkVehiclesInActivePromotions($vehicleIds);
            
            if ($hasConflict) {
                $vehicles = \App\Models\Vehicle::whereIn('id', $conflictingVehicles)
                ->get(['id', 'brand', 'model']);
                
                $vehicleList = $vehicles->map(function($v) {
                    return $v->brand . ' ' . $v->model;
                })->implode(', ');
                
                $promotionList = implode(', ', $conflictingPromotions);
                
                return back()->withErrors([
                    'applicable_vehicles' => "Les véhicules suivants sont déjà dans des promotions actives ($promotionList): $vehicleList"
                ])->withInput();
            }
        }
        
        $promotionData = [
            'company_id' => $companyId,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'discount_percentage' => $validated['discount_percentage'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => true,
            'applicable_vehicles' => $request->has('applicable_vehicles') ? $request->applicable_vehicles : null,
        ];
        
        $this->promotionRepository->create($promotionData);
        
        return redirect()->route('company.promotions.index')
            ->with('success', 'Promotion créée avec succès.');
    }
    
    public function show($id)
    {
        $promotion = $this->promotionRepository->findWithRelations($id);
        $this->authorizePromotion($promotion);
        
        return view('company.promotions.show', compact('promotion'));
    }
    
    public function edit($id)
    {
        $promotion = $this->promotionRepository->findWithRelations($id);
        $this->authorizePromotion($promotion);
        
        $company = Auth::user()->company;
        $vehicles = $this->vehicleRepository->getAllForCompany($company->id);
        
        return view('company.promotions.edit', compact('promotion', 'vehicles'));
    }
    
    public function update(Request $request, $id)
    {
        $promotion = $this->promotionRepository->find($id);
        $this->authorizePromotion($promotion);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'applicable_vehicles' => 'nullable|array',
            'applicable_vehicles.*' => 'exists:vehicles,id',
        ]);
        
        $hasReservations = $promotion->reservations()->exists();
        if ($hasReservations && $request->discount_percentage != $promotion->discount_percentage) {
            return back()->withErrors([
                'discount_percentage' => 'Impossible de modifier la remise pour les promotions déjà utilisées dans des réservations.'
            ])->withInput();
        }
        
        $companyId = Auth::user()->company->id;
        $willBeActive = $request->has('is_active');
        $today = now()->startOfDay();
        $isCurrentlyActive = $today->between(
            Carbon::parse($validated['start_date']),
            Carbon::parse($validated['end_date'])
        );
        
        if ($willBeActive && $isCurrentlyActive) {
            $isGlobalPromotion = !$request->has('applicable_vehicles');
            
            if ($isGlobalPromotion) {
                $activePromotionsCount = Promotion::where('company_id', $companyId)
                    ->where('id', '!=', $promotion->id)
                    ->where('is_active', true)
                    ->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today)
                    ->count();
                
                if ($activePromotionsCount > 0) {
                    return back()->withErrors([
                        'applicable_vehicles' => 'Une promotion globale ne peut pas être activée car d\'autres promotions actives existent déjà.'
                    ])->withInput();
                }
            } else {
                $vehicleIds = $request->applicable_vehicles;
                
                $validVehicleCount = $this->vehicleRepository->countVehiclesByCompanyAndIds($companyId, $vehicleIds);
                
                if ($validVehicleCount != count($vehicleIds)) {
                    return back()->withErrors([
                        'applicable_vehicles' => 'Vous ne pouvez sélectionner que des véhicules appartenant à votre entreprise.'
                    ])->withInput();
                }
                
                list($hasConflict, $conflictingVehicles, $conflictingPromotions) = 
                    $this->checkVehiclesInActivePromotions($vehicleIds, $promotion->id);
                
                if ($hasConflict) {
                    $vehicles = \App\Models\Vehicle::whereIn('id', $conflictingVehicles)
                    ->get(['id', 'brand', 'model']);
                    
                    $vehicleList = $vehicles->map(function($v) {
                        return $v->brand . ' ' . $v->model;
                    })->implode(', ');
                    
                    $promotionList = implode(', ', $conflictingPromotions);
                    
                    return back()->withErrors([
                        'applicable_vehicles' => "Les véhicules suivants sont déjà dans des promotions actives ($promotionList): $vehicleList"
                    ])->withInput();
                }
            }
        }
        
        $promotionData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'discount_percentage' => $validated['discount_percentage'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $willBeActive,
            'applicable_vehicles' => $request->has('applicable_vehicles') ? $request->applicable_vehicles : null,
        ];
        
        $this->promotionRepository->update($id, $promotionData);
        
        return redirect()->route('company.promotions.index')
            ->with('success', 'Promotion mise à jour avec succès.');
    }
    
    public function destroy($id)
    {
        $promotion = $this->promotionRepository->findWithRelations($id);
        $this->authorizePromotion($promotion);
        
        if ($promotion->reservations()->exists()) {
            return redirect()->route('company.promotions.index')
                ->with('error', 'Cannot delete promotion that is used in reservations.');
        }
        
        $this->promotionRepository->delete($id);
        
        return redirect()->route('company.promotions.index')
            ->with('success', 'Promotion deleted successfully.');
    }
    
    public function toggleActive($id)
    {
        $promotion = $this->promotionRepository->find($id);
        $this->authorizePromotion($promotion);
        
        $isCurrentlyActive = $promotion->is_active;
        $wouldBeActive = !$isCurrentlyActive;
        
        $today = now()->startOfDay();
        $isDateActive = $today->between(
            Carbon::parse($promotion->start_date),
            Carbon::parse($promotion->end_date)
        );
        
        if ($wouldBeActive && $isDateActive) {
            $isGlobalPromotion = $promotion->applicable_vehicles === null;
            
            if ($isGlobalPromotion) {
                $activePromotionsCount = Promotion::where('company_id', $promotion->company_id)
                    ->where('id', '!=', $promotion->id)
                    ->where('is_active', true)
                    ->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today)
                    ->count();
                
                if ($activePromotionsCount > 0) {
                    return redirect()->route('company.promotions.index')
                        ->with('error', 'Une promotion globale ne peut pas être activée car d\'autres promotions actives existent déjà.');
                }
            } else {
                $vehicleIds = $promotion->applicable_vehicles;
                
                if (is_array($vehicleIds)) {
                    list($hasConflict, $conflictingVehicles, $conflictingPromotions) = 
                        $this->checkVehiclesInActivePromotions($vehicleIds, $promotion->id);
                    
                    if ($hasConflict) {
                        $vehicles = \App\Models\Vehicle::whereIn('id', $conflictingVehicles)
                        ->get(['id', 'brand', 'model']);
                        
                        $vehicleList = $vehicles->map(function($v) {
                            return $v->brand . ' ' . $v->model;
                        })->implode(', ');
                        
                        $promotionList = implode(', ', $conflictingPromotions);
                        
                        return redirect()->route('company.promotions.index')
                            ->with('error', "Impossible d'activer la promotion. Les véhicules suivants sont déjà dans des promotions actives ($promotionList): $vehicleList");
                    }
                }
            }
        }
        
        $this->promotionRepository->update($id, [
            'is_active' => $wouldBeActive
        ]);
        
        return redirect()->route('company.promotions.index')
            ->with('success', 'Statut de la promotion mis à jour avec succès.');
    }
    
    private function authorizePromotion($promotion)
    {
        if ($promotion->company_id !== Auth::user()->company->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return true;
    }
    
    private function checkVehiclesInActivePromotions(array $vehicleIds, $excludePromotionId = null)
    {
        $today = now()->startOfDay();
        
        $query = Promotion::where('is_active', true)
            ->where('company_id', Auth::user()->company->id)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today);
        
        if ($excludePromotionId) {
            $query->where('id', '!=', $excludePromotionId);
        }
        
        $activePromotions = $query->get();
        
        $globalPromotions = $activePromotions->filter(function($promotion) {
            return $promotion->applicable_vehicles === null;
        });
        
        if ($globalPromotions->count() > 0) {
            return [
                true, 
                $vehicleIds, 
                $globalPromotions->pluck('name')->toArray()
            ];
        }
        
        $conflictingVehicles = [];
        $conflictingPromotions = [];
        
        foreach ($activePromotions as $promotion) {
            if (is_array($promotion->applicable_vehicles)) {
                $conflicts = array_intersect($vehicleIds, $promotion->applicable_vehicles);
                
                if (!empty($conflicts)) {
                    $conflictingVehicles = array_merge($conflictingVehicles, $conflicts);
                    $conflictingPromotions[] = $promotion->name;
                }
            }
        }
        
        $hasConflict = !empty($conflictingVehicles);
        
        return [
            $hasConflict, 
            array_unique($conflictingVehicles), 
            array_unique($conflictingPromotions)
        ];
    }
}