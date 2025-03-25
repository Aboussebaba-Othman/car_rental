<?php

namespace App\Repositories\Interfaces;

interface PromotionRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all promotions for a specific company
     *
     * @param int $companyId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllForCompany($companyId);
    
    /**
     * Get a promotion by ID with related data
     *
     * @param int $id
     * @return \App\Models\Promotion
     */
    public function findWithRelations($id);
    
    /**
     * Get active promotions
     * If companyId is provided, filters by company
     * Otherwise returns active promotions limited by count
     *
     * @param int|null $companyId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivePromotions($companyId, $limit = null);    
    /**
     * Get promotions that are applicable to a specific vehicle
     *
     * @param int $vehicleId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getApplicableToVehicle($vehicleId);
    
    /**
     * Get upcoming promotions that haven't started yet
     *
     * @param int $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcomingPromotions($companyId);
    
    /**
     * Get expired promotions
     *
     * @param int $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getExpiredPromotions($companyId);
    
    /**
     * Get promotion statistics for a company
     *
     * @param int $companyId
     * @return array
     */
    public function getPromotionStats($companyId);

    // public function getVehiclesInActivePromotions(array $vehicleIds, $excludePromotionId = null);

}