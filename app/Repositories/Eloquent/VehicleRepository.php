<?php

namespace App\Repositories\Eloquent;

use App\Models\Vehicle;
use App\Models\VehiclePhoto;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VehicleRepository extends BaseRepository implements VehicleRepositoryInterface
{
    /**
     * VehicleRepository constructor.
     *
     * @param Vehicle $model
     */
    public function __construct(Vehicle $model)
    {
        parent::__construct($model);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAllForCompany($companyId)
    {
        return $this->model->where('company_id', $companyId)
            ->with(['photos' => function($query) {
                $query->orderBy('is_primary', 'desc');
            }])
            ->withCount('reservations')
            ->latest()
            ->paginate(10);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findWithRelations($id)
    {
        return $this->model->with([
                'photos', 
                'reservations.user',
                'reviews'
            ])
            ->findOrFail($id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAvailableVehicles(array $criteria)
    {
        $query = $this->model->where('is_active', true)
            ->where('is_available', true)
            ->with(['photos' => function($query) {
                $query->orderBy('is_primary', 'desc');
            }]);
        
        if (isset($criteria['company_id'])) {
            $query->where('company_id', $criteria['company_id']);
        }
        
        if (isset($criteria['brand'])) {
            $query->where('brand', 'like', '%' . $criteria['brand'] . '%');
        }
        
        if (isset($criteria['model'])) {
            $query->where('model', 'like', '%' . $criteria['model'] . '%');
        }
        
        if (isset($criteria['transmission'])) {
            $query->where('transmission', $criteria['transmission']);
        }
        
        if (isset($criteria['fuel_type'])) {
            $query->where('fuel_type', $criteria['fuel_type']);
        }
        
        if (isset($criteria['min_price'])) {
            $query->where('price_per_day', '>=', $criteria['min_price']);
        }
        
        if (isset($criteria['max_price'])) {
            $query->where('price_per_day', '<=', $criteria['max_price']);
        }
        
        if (isset($criteria['min_seats'])) {
            $query->where('seats', '>=', $criteria['min_seats']);
        }
        
        if (isset($criteria['max_seats'])) {
            $query->where('seats', '<=', $criteria['max_seats']);
        }
        
        if (isset($criteria['start_date']) && isset($criteria['end_date'])) {
            $startDate = $criteria['start_date'];
            $endDate = $criteria['end_date'];
            
            // Exclude vehicles with confirmed reservations in the selected date range
            $query->whereDoesntHave('reservations', function($query) use ($startDate, $endDate) {
                $query->where('status', 'confirmed')
                    ->where(function($q) use ($startDate, $endDate) {
                        $q->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function($q2) use ($startDate, $endDate) {
                                $q2->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                            });
                    });
            });
        }
        
        if (isset($criteria['features']) && is_array($criteria['features'])) {
            foreach ($criteria['features'] as $feature) {
                $query->whereJsonContains('features', $feature);
            }
        }
        
        return $query->paginate(isset($criteria['per_page']) ? $criteria['per_page'] : 12);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getWithUpcomingReservations($companyId)
    {
        return $this->model->where('company_id', $companyId)
            ->with(['reservations' => function($query) {
                $query->where('status', 'confirmed')
                    ->where('start_date', '>=', now())
                    ->with('user')
                    ->orderBy('start_date');
            }])
            ->whereHas('reservations', function($query) {
                $query->where('status', 'confirmed')
                    ->where('start_date', '>=', now());
            })
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPrimaryPhoto($vehicleId, $photoId)
    {
        // First, reset all vehicle photos to non-primary
        DB::transaction(function() use ($vehicleId, $photoId) {
            VehiclePhoto::where('vehicle_id', $vehicleId)
                ->update(['is_primary' => false]);
            
            // Set the selected photo as primary
            VehiclePhoto::where('id', $photoId)
                ->where('vehicle_id', $vehicleId)
                ->update(['is_primary' => true]);
        });
        
        return true;
    }
    
  
    public function deletePhotos($vehicleId, array $photoIds)
    {
        $photos = VehiclePhoto::where('vehicle_id', $vehicleId)
            ->whereIn('id', $photoIds)
            ->get();
        
        foreach ($photos as $photo) {
            // Delete file from storage
            if (Storage::disk('public')->exists($photo->path)) {
                Storage::disk('public')->delete($photo->path);
            }
            $photo->delete();
        }
        
        // If all photos were deleted or no primary photo left, set a new primary photo
        $hasPrimary = VehiclePhoto::where('vehicle_id', $vehicleId)
            ->where('is_primary', true)
            ->exists();
            
        if (!$hasPrimary) {
            $firstPhoto = VehiclePhoto::where('vehicle_id', $vehicleId)->first();
            if ($firstPhoto) {
                $firstPhoto->is_primary = true;
                $firstPhoto->save();
            }
        }
        
        return true;
    }
    
   
    public function getCompanyVehicleStats($companyId)
    {
        // Get total vehicles
        $totalVehicles = $this->model->where('company_id', $companyId)->count();
        
        // Get active vehicles
        $activeVehicles = $this->model->where('company_id', $companyId)
            ->where('is_active', true)
            ->count();
        
        // Get available vehicles
        $availableVehicles = $this->model->where('company_id', $companyId)
            ->where('is_active', true)
            ->where('is_available', true)
            ->count();
        
        // Get total reservations
        $totalReservations = DB::table('reservations')
            ->join('vehicles', 'reservations.vehicle_id', '=', 'vehicles.id')
            ->where('vehicles.company_id', $companyId)
            ->count();
        
        // Get total revenue
        $totalRevenue = DB::table('reservations')
            ->join('vehicles', 'reservations.vehicle_id', '=', 'vehicles.id')
            ->where('vehicles.company_id', $companyId)
            ->where('reservations.status', 'completed')
            ->sum('reservations.total_price');
        
        // Get most popular vehicle (most reservations)
        $mostPopularVehicle = DB::table('vehicles')
            ->where('vehicles.company_id', $companyId)
            ->leftJoin('reservations', 'vehicles.id', '=', 'reservations.vehicle_id')
            ->select('vehicles.id', 'vehicles.brand', 'vehicles.model', DB::raw('count(reservations.id) as reservation_count'))
            ->groupBy('vehicles.id', 'vehicles.brand', 'vehicles.model')
            ->orderBy('reservation_count', 'desc')
            ->first();
            
        return [
            'total_vehicles' => $totalVehicles,
            'active_vehicles' => $activeVehicles,
            'available_vehicles' => $availableVehicles,
            'total_reservations' => $totalReservations,
            'total_revenue' => $totalRevenue,
            'most_popular_vehicle' => $mostPopularVehicle
        ];
    }
}