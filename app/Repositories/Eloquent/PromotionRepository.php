<?php

namespace App\Repositories\Eloquent;

use App\Models\Promotion;
use App\Repositories\Interfaces\PromotionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PromotionRepository extends BaseRepository implements PromotionRepositoryInterface
{
    public function __construct(Promotion $model)
    {
        parent::__construct($model);
    }
    
    public function getAllForCompany($companyId)
    {
        return $this->model->where('company_id', $companyId)
            ->withCount('reservations')
            ->latest()
            ->paginate(10);
    }
    
    
    public function findWithRelations($id)
    {
        return $this->model->with(['reservations', 'company'])
            ->withCount('reservations')
            ->findOrFail($id);
    }
    
   
public function getActivePromotions($companyId = null, $limit = null)
{
    $today = now()->startOfDay();
    
    $query = $this->model
        ->where('is_active', true)
        ->where('start_date', '<=', $today)
        ->where('end_date', '>=', $today)
        ->orderBy('discount_percentage', 'desc');
    
    if ($companyId !== null) {
        $query->where('company_id', $companyId);
    }
    
    if ($limit) {
        $query->take($limit);
    }
    
    return $query->get();
}
    
    
    public function getApplicableToVehicle($vehicleId)
    {
        $today = now()->startOfDay();
        
        return $this->model->whereHas('company', function($query) use ($vehicleId) {
                $query->whereHas('vehicles', function($q) use ($vehicleId) {
                    $q->where('id', $vehicleId);
                });
            })
            ->where('is_active', true)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where(function($query) use ($vehicleId) {
                $query->whereNull('applicable_vehicles')
                      ->orWhereJsonContains('applicable_vehicles', $vehicleId);
            })
            ->get();
    }
    
    
    public function getUpcomingPromotions($companyId)
    {
        $today = now()->startOfDay();
        
        return $this->model->where('company_id', $companyId)
            ->where('is_active', true)
            ->where('start_date', '>', $today)
            ->orderBy('start_date')
            ->get();
    }
    
   
    public function getExpiredPromotions($companyId)
    {
        $today = now()->startOfDay();
        
        return $this->model->where('company_id', $companyId)
            ->where('end_date', '<', $today)
            ->latest('end_date')
            ->get();
    }
    
    public function getPromotionStats($companyId)
    {
        $today = now()->startOfDay();
        
        $activeCount = $this->model->where('company_id', $companyId)
            ->where('is_active', true)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->count();
        
        $upcomingCount = $this->model->where('company_id', $companyId)
            ->where('is_active', true)
            ->where('start_date', '>', $today)
            ->count();
        
        $expiredCount = $this->model->where('company_id', $companyId)
            ->where('end_date', '<', $today)
            ->count();
        
        $mostUsed = DB::table('promotions')
            ->leftJoin('reservations', 'promotions.id', '=', 'reservations.promotion_id')
            ->select('promotions.id', 'promotions.name', DB::raw('count(reservations.id) as usage_count'))
            ->where('promotions.company_id', $companyId)
            ->groupBy('promotions.id', 'promotions.name')
            ->orderBy('usage_count', 'desc')
            ->first();
        
        $avgDiscount = $this->model->where('company_id', $companyId)->avg('discount_percentage');
        
        $revenueWithPromotions = DB::table('reservations')
            ->join('vehicles', 'reservations.vehicle_id', '=', 'vehicles.id')
            ->whereNotNull('reservations.promotion_id')
            ->where('vehicles.company_id', $companyId)
            ->where('reservations.status', 'completed')
            ->sum('reservations.total_price');
        
        return [
            'active_count' => $activeCount,
            'upcoming_count' => $upcomingCount,
            'expired_count' => $expiredCount,
            'most_used' => $mostUsed,
            'avg_discount' => $avgDiscount,
            'revenue_with_promotions' => $revenueWithPromotions
        ];
    }
}