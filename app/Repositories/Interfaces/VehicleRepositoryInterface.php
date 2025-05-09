<?php

namespace App\Repositories\Interfaces;

interface VehicleRepositoryInterface extends RepositoryInterface
{
    public function getAllForCompany($companyId);
    
    public function findWithRelations($id);
    
    public function getFeaturedVehicles($limit = 6);
    
    public function countVehiclesByCompanyAndIds($companyId, array $vehicleIds);
    
    public function deletePhotos($vehicleId, array $photoIds);
    
    public function setPrimaryPhoto($vehicleId, $photoId);
    
    public function getPaginatedVehicles(array $filters = [], string $sort = 'newest', int $perPage = 10);
    
    public function getAllBrands();

    public function getAvailableVehicles(array $filters, ?string $startDate = null, ?string $endDate = null, string $sort = 'newest', int $perPage = 10);
}