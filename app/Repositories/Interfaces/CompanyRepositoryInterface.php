<?php

namespace App\Repositories\Interfaces;

interface CompanyRepositoryInterface extends RepositoryInterface
{
    public function getAllWithUsers();
    public function findWithUser($id);
    public function getPendingValidation();
    
}