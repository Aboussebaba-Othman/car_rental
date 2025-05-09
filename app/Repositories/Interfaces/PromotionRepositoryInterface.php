<?php

namespace App\Repositories\Interfaces;

interface PromotionRepositoryInterface extends RepositoryInterface
{

    public function getAllForCompany($companyId);

    public function findWithRelations($id);
    
    public function getActivePromotions($companyId, $limit = null);    
   
    public function getApplicableToVehicle($vehicleId);
  
    public function getUpcomingPromotions($companyId);
    
    public function getExpiredPromotions($companyId);
    
    public function getPromotionStats($companyId);

    // public function getVehiclesInActivePromotions(array $vehicleIds, $excludePromotionId = null);

}