<?php

namespace App\Repositories\Eloquent;

use App\Models\Vehicle;
use App\Models\VehiclePhoto;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VehicleRepository extends BaseRepository implements VehicleRepositoryInterface
{
   
    public function __construct(Vehicle $model)
    {
        parent::__construct($model);
    }
    
 
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

    public function findWithRelations($id)
    {
        return $this->model->with([
                'photos', 
                'reservations.user',
                'reviews'
            ])
            ->findOrFail($id);
    }
    

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
    public function countVehiclesByCompanyAndIds($companyId, array $vehicleIds)
    {
        return $this->model
            ->where('company_id', $companyId)
            ->whereIn('id', $vehicleIds)
            ->count();
    }

    public function getFeaturedVehicles($limit = 6)
    {
        return $this->model
            ->where('is_active', true)
            ->where('is_available', true)
            ->with('photos')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Get the model instance
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    public function getPaginatedVehicles(array $filters = [], string $sort = 'newest', int $perPage = 10)
    {
        $query = $this->model->query()
            ->with(['photos', 'company'])
            ->where('is_active', true)
            ->where('is_available', true);
        
        // Apply filters
        if (!empty($filters['brand'])) {
            $query->where('brand', $filters['brand']);
        }
        
        if (!empty($filters['fuel_type'])) {
            $query->where('fuel_type', $filters['fuel_type']);
        }
        
        if (!empty($filters['seats'])) {
            $query->where('seats', $filters['seats']);
        }
        
        if (!empty($filters['price_min'])) {
            $query->where('price_per_day', '>=', $filters['price_min']);
        }
        
        if (!empty($filters['price_max'])) {
            $query->where('price_per_day', '<=', $filters['price_max']);
        }
        
        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                break;
                
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
                break;
                
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
                
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        return $query->paginate($perPage)->withQueryString();
    }
    
    /**
     * Get all unique brands
     *
     * @return array
     */
    public function getAllBrands()
    {
        return $this->model
            ->select('brand')
            ->where('is_active', true)
            ->groupBy('brand')
            ->pluck('brand')
            ->toArray();
    }
}