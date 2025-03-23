<?php

namespace App\Repositories\Interfaces;

interface VehicleRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all vehicles for a specific company with their photos
     *
     * @param int $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllForCompany($companyId);
    
    /**
     * Get a vehicle by ID with its photos and related data
     *
     * @param int $id
     * @return \App\Models\Vehicle
     */
    public function findWithRelations($id);
    
    /**
     * Get vehicles based on availability and filter criteria
     *
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableVehicles(array $criteria);
    
    /**
     * Get vehicles with upcoming reservations for a company
     *
     * @param int $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWithUpcomingReservations($companyId);
    
    /**
     * Set the primary photo for a vehicle
     *
     * @param int $vehicleId
     * @param int $photoId
     * @return bool
     */
    public function setPrimaryPhoto($vehicleId, $photoId);
    
    /**
     * Delete multiple photos for a vehicle
     *
     * @param int $vehicleId
     * @param array $photoIds
     * @return bool
     */
    public function deletePhotos($vehicleId, array $photoIds);
    
    /**
     * Get vehicles statistics for a company
     *
     * @param int $companyId
     * @return array
     */
    public function getCompanyVehicleStats($companyId);
}