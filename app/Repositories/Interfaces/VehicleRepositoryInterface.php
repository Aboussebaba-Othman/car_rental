<?php

namespace App\Repositories\Interfaces;

interface VehicleRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all vehicles for a specific company with pagination
     *
     * @param int $companyId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllForCompany($companyId);
    
    /**
     * Get a vehicle by ID with related data
     *
     * @param int $id
     * @return \App\Models\Vehicle
     */
    public function findWithRelations($id);
    
    /**
     * Get featured vehicles (active and available)
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedVehicles($limit = 6);
    
    /**
     * Count vehicles by company ID and array of vehicle IDs
     *
     * @param int $companyId
     * @param array $vehicleIds
     * @return int
     */
    public function countVehiclesByCompanyAndIds($companyId, array $vehicleIds);
    
    /**
     * Delete photos for a vehicle
     *
     * @param int $vehicleId
     * @param array $photoIds
     * @return bool
     */
    public function deletePhotos($vehicleId, array $photoIds);
    
    /**
     * Set primary photo for a vehicle
     *
     * @param int $vehicleId
     * @param int $photoId
     * @return bool
     */
    public function setPrimaryPhoto($vehicleId, $photoId);
    
    /**
     * Get paginated vehicles with filters and sorting
     *
     * @param array $filters
     * @param string $sort
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedVehicles(array $filters = [], string $sort = 'newest', int $perPage = 10);
    
    /**
     * Get all unique brands
     *
     * @return array
     */
    public function getAllBrands();
}